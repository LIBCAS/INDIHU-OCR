<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>INDIHU OCR</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/dropzone.min.css" rel="stylesheet">
  </head>

  <body style="align-items: normal">
    <div class="lds-css ng-scope">
      <div class="lds-spinner" style="100%;height:100%;position: absolute; top: 410px; left: calc(50% - 60px); z-index: 20;display:none;">
        <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
      </div>    
    </div>
    <div class="container-fluid">
    <div class="form-dropzone row">
      <div class="col">
      <form method="post" action="" enctype="multipart/form-data">
        <h1 class="mb-3"><a href="/ocr-web" style="color: black; text-decoration: none">INDIHU OCR</a></h1>
        <h1 class="h3 mb-3 font-weight-normal">Nahrajte soubory</h1>
        <div class="dropzone font-blue" id="myDropZone"></div>
        <br/>
        <label for="format">Výstupní formát</label>
        <select class="custom-select d-block w-100 mb-3" name="format" id="format" required>
          <option value="pdf">PDF</option>
          <option value="txt">Text</option>        
        </select>
        <label for="lang">Jazyk</label>
        <select class="custom-select d-block w-100 mb-3" name="lang" id="lang" required>
          <option value="eng">Angličtina</option>
          <option value="ces">Čeština</option>
          <option value="slk">Slovenština</option>
          <option value="deu">Němčina</option>
          <option value="rus">Ruština</option>
          <option value="fra">Francouzština</option>
          <option value="spa">Španělština</option>
          <option value="lat">Latina</option>
        </select>
        <button id="send" class="btn btn-lg btn-primary btn-block" type="submit">Konvertovat</button>
        <a href="" id="download" class="btn btn-lg btn-success btn-block" style="display: none" download>Stáhnout výsledek</a>
        <div id="new" class="mt-2" style="text-align: center; display: none" title="Pozor, stiskem ztratíte výsledek aktuální konverze!">
          <a href="/ocr-web" style="color: #d44950">Vymazat data</a>
        </div>
        <h4 class="h4 mt-4 mb-3 font-weight-normal">Jak zlepšit kvalitu výstupu</h4>
        <ul>
          <li>Alespoň 300 DPI</li>
          <li>Binarizace - převod obrázku do černobílé podoby</li>
          <li>Narovnání šikmo naskenovaných obrázků</li>
          <li>Odstranění tmavých rámců okolo obrázku</li>
		  <li>K úpravě obrázků můžete použít nástroj <a href="https://www.irfanview.com/" target="_blank">InfanView</a></li>
        </ul>
      
      </form>
    </div>
    </div>
    <div class="row footer-row">
      <div class="col footer">
        <p class="mt-5"><a href="https://indihu.cz/" target="_blank" class="footer-link">Projekt INDIHU realizuje Akademie věd ČR, Národní knihovna ČR, Archeologický ústav AV ČR (Brno), Archeologický ústav AV ČR (Praha), Etnologický ústav AV ČR, Filozofický ústav AV ČR, Ústav pro českou literaturu AV ČR, Ústav dějin umění AV ČR.</a></p>
      </div>
    </div>
    </div>

    <style>
      .form-dropzone{
        width: 100%;
        max-width: 700px;
        padding: 15px;
        margin: 0 auto;
      }

      .footer-row {
        height: 200px;
        margin-top: 12px;
      }

      .footer {
        padding: 0;
        background-color: #4a4449;
      }

      .footer p {
        padding: 0 40px;
        color: white;
        max-width: 700px;
        margin: 0 auto;
      }
	  
	  .footer-link {
        color: white;
      }

      .footer-link:hover {
        color: white;
      }
    </style>

    <style type="text/css">
      @keyframes lds-spinner {
        0% {
          opacity: 1;
        }
        100% {
          opacity: 0;
        }
      }
      @-webkit-keyframes lds-spinner {
        0% {
          opacity: 1;
        }
        100% {
          opacity: 0;
        }
      }
      .lds-spinner {
        position: relative;
      }
      .lds-spinner div {
        left: 94px;
        top: 48px;
        position: absolute;
        -webkit-animation: lds-spinner linear 1.5s infinite;
        animation: lds-spinner linear 1.5s infinite;
        background: #007bff;
        width: 12px;
        height: 24px;
        border-radius: 40%;
        -webkit-transform-origin: 6px 52px;
        transform-origin: 6px 52px;
      }
      .lds-spinner div:nth-child(1) {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
        -webkit-animation-delay: -1.375s;
        animation-delay: -1.375s;
      }
      .lds-spinner div:nth-child(2) {
        -webkit-transform: rotate(30deg);
        transform: rotate(30deg);
        -webkit-animation-delay: -1.25s;
        animation-delay: -1.25s;
      }
      .lds-spinner div:nth-child(3) {
        -webkit-transform: rotate(60deg);
        transform: rotate(60deg);
        -webkit-animation-delay: -1.125s;
        animation-delay: -1.125s;
      }
      .lds-spinner div:nth-child(4) {
        -webkit-transform: rotate(90deg);
        transform: rotate(90deg);
        -webkit-animation-delay: -1s;
        animation-delay: -1s;
      }
      .lds-spinner div:nth-child(5) {
        -webkit-transform: rotate(120deg);
        transform: rotate(120deg);
        -webkit-animation-delay: -0.875s;
        animation-delay: -0.875s;
      }
      .lds-spinner div:nth-child(6) {
        -webkit-transform: rotate(150deg);
        transform: rotate(150deg);
        -webkit-animation-delay: -0.75s;
        animation-delay: -0.75s;
      }
      .lds-spinner div:nth-child(7) {
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
        -webkit-animation-delay: -0.625s;
        animation-delay: -0.625s;
      }
      .lds-spinner div:nth-child(8) {
        -webkit-transform: rotate(210deg);
        transform: rotate(210deg);
        -webkit-animation-delay: -0.5s;
        animation-delay: -0.5s;
      }
      .lds-spinner div:nth-child(9) {
        -webkit-transform: rotate(240deg);
        transform: rotate(240deg);
        -webkit-animation-delay: -0.375s;
        animation-delay: -0.375s;
      }
      .lds-spinner div:nth-child(10) {
        -webkit-transform: rotate(270deg);
        transform: rotate(270deg);
        -webkit-animation-delay: -0.25s;
        animation-delay: -0.25s;
      }
      .lds-spinner div:nth-child(11) {
        -webkit-transform: rotate(300deg);
        transform: rotate(300deg);
        -webkit-animation-delay: -0.125s;
        animation-delay: -0.125s;
      }
      .lds-spinner div:nth-child(12) {
        -webkit-transform: rotate(330deg);
        transform: rotate(330deg);
        -webkit-animation-delay: 0s;
        animation-delay: 0s;
      }
      .lds-spinner {
        width: 140px !important;
        height: 140px !important;
        -webkit-transform: translate(-70px, -70px) scale(0.7) translate(70px, 70px);
        transform: translate(-70px, -70px) scale(0.7) translate(70px, 70px);
      }
    </style>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-slim.min.js"><\/script>')</script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/dropzone.min.js"></script>

    <script>
      var uploadedFiles = [];
            
      Dropzone.autoDiscover = false;
      $(function () {
        $("div#myDropZone").dropzone({ 
          url: "upload.php",
          maxFiles: 10,
          maxFilesize: 10,
          dictDefaultMessage: "Klikněte nebo sem přesuňte soubory",
          dictFileTooBig: "Tento soubor je příliš velký( {l}{l}filesize{r}{r} ), maximální povolená velikost je {l}{l}maxFilesize{r}{r}",
          dictRemoveFile: "Odstranit soubor",
          dictMaxFilesExceeded: "Je povoleno nahrát maximálně 10 souborů",
          acceptedFiles: "image/jpeg, image/png, application/pdf",
          clickable: [".dropzone"],
          dictCancelUpload: "Přerušit nahrávání",
          addRemoveLinks: true,
          sending: function(file, xhr, formData){
            $("input[name='send']").prop("type", "button");
          },
          success: function (file, response) { 
            uploadedFiles.push({name: file.name, path: response['path'], type: file.type, url: response['url']}); 
            
            file.path = response['path'];
            file.url = response['url'];
            $("input[name='send']").prop("type", "submit");
          },
          removedfile: function (file) {
            var obj = [file.name, file.path, file.type]; 
            var remainingFiles = []; 

            uploadedFiles.forEach(function(e){
              if(e.path != file.path){
                remainingFiles.push(e);
              }
            });

            uploadedFiles = remainingFiles;
            
            jQuery.ajax({
              type: 'POST',
              url: 'delete.php',
                data: {
                  'path': file.path
                }
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
          }
        });
      });

      var alreadyConverted = false;

      $(document).ready(function(){
        $('form').append('<input type="hidden" name="fileToSend" id="fileToSend" value="">');
        
        $('form').submit(function(e){
                        
          if(uploadedFiles.length > 1 || $('#format').val() == 'pdf'){
            e.preventDefault();

            $("#send").attr('disabled','disabled');
            $('.lds-spinner').show();
            
            data = {
              format: $('#format').val(),
              lang: $('#lang').val(),
              files: uploadedFiles
            }
            
            ajaxRequest = $.ajax({
              url: "send.php",
              type: "post",
              data: data
            });
            
            ajaxRequest.done(function (response){
              $('.lds-spinner').hide();
              
              $('#send').css('display', 'none');
              $('#new').css('display', 'block');
              $('#download').css('display', 'block');
              $("#download").prop('href', '/ocr-web' + response);

              alreadyConverted = true;
            });
          } else {
            $('.lds-spinner').show();
            $('form').prop('method', 'post');
            $('form').prop('action', 'send-single.php');
            file = JSON.stringify(uploadedFiles);
            $('#fileToSend').val(file);                     
          }
        });

        $("#format").change(function(){
            if(alreadyConverted){
              $('#send').css('display', 'block');
              $("#send").removeAttr('disabled');
            }
        });
        
      });      

    </script>
        
  </body>
</html>
