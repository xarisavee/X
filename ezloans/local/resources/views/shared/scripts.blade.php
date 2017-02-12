<script type="text/javascript">
	oFReader = new FileReader(), rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;

	oFReader.onload = function (oFREvent) {

		var img=new Image();
		img.onload=function(){
			img.width=200;
			img.height=200;
			var canvas=document.createElement("canvas");
			var ctx=canvas.getContext("2d");
			canvas.width=200;
			canvas.height=200;
			ctx.drawImage(img,0,0,img.width,img.height);
			document.getElementById("preview").src = canvas.toDataURL();
		}
		img.src=oFREvent.target.result;
	};

	function loadImageFile() {
		if (document.getElementById("fileToUpload").files.length === 0) { return; }
		var oFile = document.getElementById("fileToUpload").files[0];
		if (!rFilter.test(oFile.type)) { alert("You must select a valid image file!"); return; }
		oFReader.readAsDataURL(oFile);
	};
                      
  function alphaOnly(event) {
			var key = event.keyCode;
			return ((key >= 65 && key <= 90) || key == 8 || key == 32 || (key >= 37 && key <=40 ) || key == 9);
  };
  
  function numericOnly(event){
			var key = event.keyCode;
			return ((key >=48 && key <=57) ||  key == 43 || key == 32 || key == 8 || (key >= 37 && key <=40 ) || key == 9);
  };
</script>