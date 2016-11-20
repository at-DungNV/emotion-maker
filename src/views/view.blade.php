<!DOCTYPE html>
<html>
	<head>
		<title>Emotion Maker</title>
		<meta charset="utf-8" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js">
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
		<style type="text/css">
      body {
        margin: 0 auto;
      }
			.relative {
				position: relative;
        float: left;
        margin-right: 20px;
			}
      .list {
        float: left;
        width : 500px;
        height : 400px;
        border : 1px solid gray;
      }
			#imagesFace {
			}
			.borderFace{
				position: absolute;
				border: 4px solid #fbc433;
			}
			.detail {
				position: absolute;
			    background-color: #7A7895;
			    color: #ffffff;
			    width: 220px;
			    height: auto;
			    padding: 10px;
			    display: none;
			    z-index: 100;
			    font-size: 14px;
			    opacity: 0.85;
			}
			.detail p {
				text-align: left;
			}
			.detail p span {
				width: 85px;
    			display: inline-block;
			}
      a {
        font-weight: bold;
      }
      h4 #detect{
        font-weight: bold;
        color: #291bc1;
      }
      h4 #maxim{
        color: #544160;
      }
      h4 #advice{
        font-style: italic;
        color: #222;
        text-shadow: 0px 2px 3px #555;
      }
		</style>
	</head>
	<body>
    <div class="alert alert-info" style="border: 0px; margin-top: 0px">
    		<h2>PHP2 Team</h2>
  	</div>
    <div class="container">
		<?php
			// This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
			require_once 'HTTP/Request2.php';

			if (isset($_POST['submit'])) {
				$urlImage = $_POST['urlImage'];
				$request = new Http_Request2('https://api.projectoxford.ai/emotion/v1.0/recognize');

				$url = $request->getUrl();

				$headers = array(
				  // Request headers
				  'Content-Type' => 'application/json',
				  'Ocp-Apim-Subscription-Key' => '912744225dbf4be78b00a1e9067e7cf7'
				);

				$request->setHeader($headers);


				$parameters = array(
				// Request parameters
				);

				$url->setQueryVariables($parameters);

				$request->setMethod(HTTP_Request2::METHOD_POST);

				// Request body
				$setBodyImages = '{ "url": "'.$urlImage.'" }';
				$request->setBody($setBodyImages);

				try
				{
					$response = $request->send();
					$getJson = $response->getBody();

					$arGet = array();
					$arGet = json_decode($getJson, true);
			?>
				<script type="text/javascript">
          var url = '{{ url('emotion/show') }}';

          $("a").click(function(){
    				$link_img = $(this).text();
    				$("#imgurl").val($link_img);

    			});

					$(function(){
						<?php
			    		for ($i=0; $i < count($arGet) ; $i++) {
				    	?>
			    		  $('.borderFace<?php echo $i;?>').mouseover(function(){
			        		$('.detail<?php echo $i;?>').css('display','block');
			        	});

			        	$('.borderFace<?php echo $i;?>').click(function(){
                  $('#advice').text("");
                  $("#list-table").empty();
			        		<?php $keymax[$i] = array_keys($arGet[$i]['scores'], max($arGet[$i]['scores'])); ?>

			        		//request ajax
			        		var keymax<?php echo $i; ?> = '<?php echo $keymax[$i][0] ?>';
                  console.log(keymax<?php echo $i; ?>);
                  $.getJSON( url + "/"+ keymax<?php echo $i; ?>, function( data ) {
                    $('#detect').html("Your feeling is : "+keymax<?php echo $i; ?>);
                    $('#maxim').text("Maxim for you: ");
                    $('#advice').text(data.advice);
                    $('#para').text("Music songs for your emotion :");
                    console.log(data.songs);
                    for(i=0; i<data.songs.length; i++){
                      var row =
                      "<a class='list-group-item' href='"+data.songs[i].link+"' target='_blank' >"+data.songs[i].name+"</a>";
                      $('#list-table').append(row);
                    }
                  });
			        	});

			        	$('.borderFace<?php echo $i;?>').mouseout(function(){
						        $('.detail<?php echo $i;?>').css('display','none');
						    });
			        <?php
			    		}
				    	?>
					});
				</script>
    <div class="row">
				<div class="relative">
			  	<img id="imagesFace" width="550" height="400px" src="<?php echo $urlImage;?>" />
    			<?php
    				$size = getimagesize($urlImage);
    				foreach ($arGet as $k => $arFace) {
    			?>
    				  	<div class="borderFace borderFace<?php echo $k;?>"
    				  			style="top: <?php echo $arFace['faceRectangle']['top']*400/$size[1]; ?>px;
    									left: <?php echo $arFace['faceRectangle']['left']*550/$size[0]; ?>px;
    									width: <?php echo $arFace['faceRectangle']['width']*550/$size[0]; ?>px;
    									height: <?php echo $arFace['faceRectangle']['height']*400/$size[1]; ?>px;
    				  			"
    				  	>

    				  	</div>
    				  	<div class="detail detail<?php echo $k;?>"
    				  			style="top: <?php echo $arFace['faceRectangle']['top']*400/$size[1]; ?>px;
    									left: <?php echo ($arFace['faceRectangle']['left']*550/$size[0]+$arFace['faceRectangle']['width']*550/$size[0]); ?>px;
    							"

    				  	>
    				  			<p>
    				  				<span>anger</span>
    				  				<?php echo $arFace['scores']['anger'];?>
    				  			</p>
    				  			<p>
    				  				<span>contempt</span>
    				  				<?php echo $arFace['scores']['contempt'];?>
    				  			</p>
    				  			<p>
    				  				<span>disgust</span>
    				  				<?php echo $arFace['scores']['disgust'];?>
    				  			</p>
    				  			<p>
    				  				<span>fear</span>
    				  				<?php echo $arFace['scores']['fear'];?>
    				  			</p>
    				  			<p>
    				  				<span>happiness</span>
    				  				<?php echo $arFace['scores']['happiness'];?>
    				  			</p>
    				  			<p>
    				  				<span>neutral</span>
    				  				<?php echo $arFace['scores']['neutral'];?>
    				  			</p>
    				  			<p>
    				  				<span>sadness</span>
    				  				<?php echo $arFace['scores']['sadness'];?>
    				  			</p>
    				  			<p>
    				  				<span>surprise</span>
    				  				<?php echo $arFace['scores']['surprise'];?>
    				  			</p>
    				  	</div>
    			<?php
    				}
    			?>
				</div>

			<?php
				}
				catch (HttpException $ex)
				{
					echo $ex;
				}
			}
		?>

		  <div class="list" style="padding:10px; overflow: auto;" id="list">
      <div class="alert alert-info" id="detect">
      </div>
      <div class="panel panel-info">
      <div class="panel-heading" id="maxim"></div>
      <div class="panel-body">
        <div class="list-group" id="advice" style="text-align:center">
        </div>
      </div>
      </div>
      <div class="panel panel-info">
      <div class="panel-heading" id="para"></div>
      <div class="panel-body">
        <div class="list-group" id="list-table">
        </div>
      </div>
      </div>
		</div>
    </div>
    <div style="clear:both;"></div>
    <div class="form-group">
  		<form class="form-group" method="post" action="{{ route('emotion.submit') }}">
        <div class="col-md-5">
        <input type="text" class="form-control" name="urlImage" size="70px" id="urlimg" placeholder="hãy nhập url images" />
        </div>
        <input type="submit" class="btn btn-default col-md-1" name="submit" value="submit" />
  		</form>
    </div>
    <br>
    <h3>Some images demo</h3>
  	<a class="selection">https://portalstoragewuprod.azureedge.net/emotion/recognition1.jpg</a><br>
  	<a class="selection">https://portalstoragewuprod.azureedge.net/face/demo/detection%205.jpg</a><br>
  	<a class="selection">https://portalstoragewuprod.azureedge.net/emotion/recognition2.jpg</a><br>
  	<a class="selection">https://portalstoragewuprod.azureedge.net/emotion/recognition3.jpg</a><br>
  	<a class="selection">https://portalstoragewuprod.azureedge.net/emotion/recognition4.jpg</a><br>
  </div>
  <div class="alert alert-info" style="border: 0px; margin-top: 5px; margin-bottom: 0px;">
  	Lien he nhom PHP2
	</div>
	</body>
</html>
