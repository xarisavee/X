$('document').ready(function(){
	$('input:checkbox').prop('checked', false);
	$('.myPopover').popover();
	$('body').on('click', function (e) {
		$('[data-toggle="popover"]').each(function () {
			//the 'is' for buttons that trigger popups
			//the 'has' for icons within a button that triggers a popup
			if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
				$(this).popover('hide');
			}
		});
	});
	
	
});

function CustomAlert(){
	this.render = function(dialog, num){
		var winW = window.innerWidth;
		var winH = window.innerHeight;
		var dialogoverlay = document.getElementById('dialogoverlay');
		var dialogbox = document.getElementById('dialogbox');
		dialogoverlay.style.display = "block";
		dialogoverlay.style.height=winH+"px";
		dialogbox.style.left = (winW/2) - (550 * .5) + "px";
		dialogbox.style.top = "100px";
		dialogbox.style.display = "block";
		document.getElementById('dialogboxhead').innerHTML = "Message from Admin";
		document.getElementById('dialogboxbody').innerHTML = dialog;
		if(num==1){
			document.getElementById('dialogboxfoot').innerHTML = '<button onclick="Alert.ok()" class="btn btn-black btn-md">OK</button>';
		}else{
			document.getElementById('dialogboxfoot').innerHTML = '<button onclick="Alert.ok1()" class="btn btn-black btn-md">OK</button>';
		}
	}
	this.ok = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
		location.replace("index.php");
	}
	this.ok1 = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
		location.replace("index.php");
	}
}
var Alert = new CustomAlert();



