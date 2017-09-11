/*
 * Carbon-Forum
 * https://github.com/lincanbin/Carbon-Forum
 *
 * Copyright 2006-2015 Canbin Lin (lincanbin@hotmail.com)
 * http://www.94cb.com/
 *
 * Licensed under the Apache License, Version 2.0:
 * http://www.apache.org/licenses/LICENSE-2.0
 * 
 * A high performance open-source forum software written in PHP. 
 */

/*
//编辑框自适应高度
document.getElementById("Content").onkeyup = function(e) {
	document.getElementById("Content").style.height = (parseInt(document.getElementById("Content").scrollHeight) + 2) + "px";
};
*/
//提交前的检查
function CreateNewTopic() {
	if (!document.NewForm.Title.value.length) {
		CarbonAlert(Lang['Title_Can_Not_Be_Empty']);
		return false;
	} else if (document.NewForm.Title.value.replace(/[^\x00-\xff]/g, "***").length > MaxTitleChars) {
		CarbonAlert(Lang['Title_Too_Long'].replace("{{MaxTitleChars}}", MaxTitleChars).replace("{{Current_Title_Length}}", document.NewForm.Title.value.replace(/[^\x00-\xff]/g, "***").length));
		return false;
	}
	else if ($("#BoardID").val() == '0')
	{
		CarbonAlert('请选择版块');
		return false;
	} else {
		var toast = $.afui.toast(Lang['Submitting']);
		$("#PublishButton").val(Lang['Submitting']);
		var MarkdownConverter = new showdown.Converter(),
		Content = $("#Content").val();
		var origin, href;
		$($.afui.activeDiv).find(".picture-list li").each(function () {
			origin = $.trim($(this).attr("title"));
			href = $.trim($(this).attr("rel"));
			href = '<img src="' + href + '" class="block">';
			var reg = new RegExp("\\[" + origin + "\\]", "g");
			Content = Content.replace(reg, href);
		});


		$($.afui.activeDiv).find(".emotion-list li").each(function () {
			origin = $(this).attr('rel');
			href = $(this).attr('title');
			href = '<img src="' + href + '">';
			var reg = new RegExp("\\[" + origin + "\\]", "g");
			Content = Content.replace(reg, href);
		});

		$.ajax({
			url: WebsitePath + '/new',
			data: {
				FormHash: document.NewForm.FormHash.value,
				token: accessToken,
				Title: document.NewForm.Title.value,
				BoardID: document.NewForm.BoardID.value,
				Content: Content
			},
			type: 'post',
			dataType: 'json',
			success: function(data) {
				$(".picture-list li").remove();
				toast.hide();
				if (data.Status == 1) {
					// location.href = WebsitePath + "/t/" + data.TopicID + "?token=" + accessToken;
					$('#mainview').attr('data-title', document.NewForm.Title.value);
					document.NewForm.Title.value = '';
					document.NewForm.BoardID.value = '0';
					document.NewForm.Content.value = '';
					$(document.NewForm.Content).next().find("li").remove();
					$.afui.loadContent(
						WebsitePath + "/t/" + data.TopicID + "?token=" + accessToken,
						false,
						false,
						"slide",
						document.getElementById('mainview')
					);
				} else {
					CarbonAlert(data.ErrorMessage);
				}
			},
			error: function() {
				CarbonAlert(Lang['Submit_Failure']);
				$("#PublishButton").val(Lang['Submit_Again']);
			}
		});
	}
	return true;
}

function CheckTag(TagName, IsAdd) {
	TagName = $.trim(TagName);
	var show = true;
	var i = 1;
	$("input[name='Tag[]']").each(function(index) {
		if (IsAdd && i >= MaxTagNum) {
			CarbonAlert(Lang['Tags_Too_Much'].replace("{{MaxTagNum}}", MaxTagNum));
			show = false;
		}
		if (TagName == $(this).val() || TagName == '') {
			show = false;
		}
		//简单的前端过滤，后端有更严格的白名单过滤所以这里随便写个正则应付下了。
		if (TagName.match(/[&|<|>|"|']/g) != null) {
			//alert('Invalid input! ')
			show = false;
		}
		i++;
	});
	return show;
}

function GetTags() {
	var CurrentContentHash = md5(document.NewForm.Title.value + document.NewForm.Content.value);
	//取Title与Content 联合Hash值，与之前input的内容比较，不同则开始获取话题，随后保存进hidden input。
	if (CurrentContentHash != document.NewForm.ContentHash.value) {
		if (document.NewForm.Title.value.length || document.NewForm.Content.value.length) {
			$.ajax({
				url: WebsitePath + '/json/get_tags',
				data: {
					Title: document.NewForm.Title.value,
					Content: document.NewForm.Content.value
				},
				type: 'post',
				dataType: 'json',
				success: function(data) {
					if (data.status) {
						$("#TagsList").html('');
						for (var i = 0; i < data.lists.length; i++) {
							if (CheckTag(data.lists[i], 0)) {
								TagsListAppend(data.lists[i], i);
							}
						}
					}
				}
			});
		}
		document.NewForm.ContentHash.value = CurrentContentHash;
	}
}

function TagsListAppend(TagName, id) {
	$("#TagsList").append('<a class="button" onclick="javascript:AddTag(\'' + TagName + '\',' + id + ');" id="TagsList' + id + '">' + TagName + '<span style="float:right;">+&nbsp;&nbsp;</span></a>&nbsp;');
	//document.NewForm.AlternativeTag.focus();
}

function AddTag(TagName, id) {
	if (CheckTag(TagName, 1)) {
		$("#SelectTags").append('<li id="Tag' + id + '"><a onclick="javascript:TagRemove(\'' + TagName + '\',' + id + ');">' + TagName + '<span style="float:right;" class="fa fa-close"></span><input type="hidden" name="Tag[]" value="' + TagName + '" /></a></li>');
		$("#TagsList" + id).remove();
	}
	//document.NewForm.AlternativeTag.focus();
	$("#AlternativeTag").val("");
	if ($("input[name='Tag[]']").length == MaxTagNum) {
		$("#AlternativeTag").attr("disabled", true);
		$("#AlternativeTag").attr("placeholder", Lang['Tags_Too_Much'].replace("{{MaxTagNum}}", MaxTagNum));
	}
}

$(function() {
	$("#AlternativeTag").keydown(function(e) {
		var e = e || event;
		switch (e.keyCode) {
		case 13:
			if ($("#AlternativeTag").val().length != 0) {
				AddTag($("#AlternativeTag").val(), Math.round(new Date().getTime() / 1000));
			}
			break;
		default:
			return true;
		}
	});
});

function TagRemove(TagName, id) {
	$("#Tag" + id).remove();
	TagsListAppend(TagName, id);
	if ($("input[name='Tag[]']").length < MaxTagNum) {
		$("#AlternativeTag").attr("disabled", false);
		$("#AlternativeTag").attr("placeholder", Lang['Add_Tags']);
	}
	document.NewForm.AlternativeTag.focus();
}