<!DOCTYPE html>
<html>
	<head>
		<title>Demo02</title>
		<meta charset="utf-8" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js">
    </script>
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
			    width: auto;
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
		</style>
	</head>
	<body>
		<h2>PHP2 Team</h2>
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
                    $('#detect').text("your feeling is : "+keymax<?php echo $i; ?>);
                    $('#para').text("so we have some advice for you :");
                    $('#advice').text(data.advice);
                    $('#para').text("music songs for your emotion :");
                    console.log(data.songs);
                    for(i=0; i<data.songs.length; i++){
                      var row = "<tr>"+
                      "<td><a href='"+data.songs[i].link+"' target='_blank' >"+data.songs[i].name+"</a></td>"+
                      "</tr>";
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
    				  			style="top: <?php echo $arFace['faceRectangle']['top']+5; ?>px;
    									left: <?php echo ($arFace['faceRectangle']['left']+35+$arFace['faceRectangle']['width']); ?>px;
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

		<div class="list" id="list">
      <h4 id="detect"></h4>
      <h4 id="para"></h4>
      <h4 id="advice"></h4>
      <h4 id="music"></h4>
      <table id="list-table">

      </table>
		</div>
    <div style="clear:both;"></div>

		<form method="post" action="{{ route('emotion.submit') }}">
			<br />
			<input type="text" name="urlImage" size="70px" placeholder="hãy nhập url images" />
			<input type="submit" name="submit" value="submit" />
		</form>
	</body>
</html>
