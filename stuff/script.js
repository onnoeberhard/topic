function focusMessage() {
	document.getElementById("homeChatMessageText").focus();
	var objDiv = document.getElementById("homeChat");
	objDiv.style.backgroundColor = "#fff";
	objDiv.scrollTop = objDiv.scrollHeight;	
}
function openChat(a) {
	document.getElementById('homeActionCard').addClassName('flipped');
	if(!a) {
		document.getElementById('homeActionCard').addClassName('a');
	}
}
function closeChat() {
	document.getElementById('homeActionCard').removeClassName('a');
	document.getElementById('homeActionCard').removeClassName('flipped');
}
function adHelpTitle() {
	document.getElementById('adsTitleDialog').style.display = 'block';
}
function adCloseHelpTitle() {
	document.getElementById('adsTitleDialog').style.display = 'none';
}
function adHelpLink() {
	document.getElementById('adsLinkDialog').style.display = 'block';
}
function adCloseHelpLink() {
	document.getElementById('adsLinkDialog').style.display = 'none';
}
function adHelpImg() {
	document.getElementById('adsImgDialog').style.display = 'block';
}
function adCloseHelpImg() {
	document.getElementById('adsImgDialog').style.display = 'none';
}
function adCloseFillOutError() {
	document.getElementById('adsFillOutErrorDialog').style.display = 'none';
}
function adcr_format() {
	var a = "png";
	var b = "gif";
	if(document.getElementById('adcr_gif').selected) {
		a = "gif";
		b = "png";
	}
	document.getElementById('adprice'+a).style.display = "block";
	document.getElementById('adprice'+b).style.display = "none";
}
function adcr_dp() {
	for(var i = 0; i < document.getElementsByClassName('addynamicprice').length; i++)
		document.getElementsByClassName('addynamicprice')[i].style.display = "block";
	for(var i = 0; i < document.getElementsByClassName('adconstantprice').length; i++)
		document.getElementsByClassName('adconstantprice')[i].style.display = "none";
	document.getElementById('adprice').value = "dynamic";
}
function adcr_cp() {
	for(var i = 0; i < document.getElementsByClassName('addynamicprice').length; i++)
		document.getElementsByClassName('addynamicprice')[i].style.display = "none";
	for(var i = 0; i < document.getElementsByClassName('adconstantprice').length; i++)
		document.getElementsByClassName('adconstantprice')[i].style.display = "block";
	document.getElementById('adprice').value = "constant";
}
var likeVis;
var dislikeVis;
function statusShowMore(a) {
	likeVis = (document.getElementById('sl_' + a).style.color == "green");
	dislikeVis = (document.getElementById('sdl_' + a).style.color == "red");
	document.getElementById('statusMore_' + a).style.display = "block";
	document.getElementById('ssl_' + a).style.display = "block";
	document.getElementById('sl_' + a).style.display = "block";
	document.getElementById('sdl_' + a).style.display = "block";
	document.getElementById('ssm_' + a).style.display = "none";
}
function statusShowLess(a) {
	document.getElementById('statusMore_' + a).style.display = "none";
	document.getElementById('ssl_' + a).style.display = "none";
	document.getElementById('sl_' + a).style.display = "";
	document.getElementById('sdl_' + a).style.display = "";
	document.getElementById('ssm_' + a).style.display = "";
	if(likeVis)document.getElementById('sl_' + a).style.display = "block";
	if(dislikeVis)document.getElementById('sdl_' + a).style.display = "block";
}
/*var a = function() {
	if(document.getElementsByClassName('back')[0].style.opacity == 1)
		return true;
	return false;
}*/