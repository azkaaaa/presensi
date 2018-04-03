@extends ('backend.login.master') @section ('content')
	<style type="text/css">
		body { font-family: Helvetica, sans-serif; }
		h2, h3 { margin-top:0; }
		form { margin-top: 15px; }
		form > input { margin-right: 15px; }
		#results { float:right; margin:20px; padding:20px; border:1px solid; background:#ccc; }
	</style>

	<div id="results">Your captured image will appear here...</div>
	
	<h1>Capture Web camera image using WebcamJS and PHP - Theonlytutorials.com</h1>
	<h3>Demonstrates simple 600x460 capture &amp; display</h3>
	
	<div id="my_camera"></div>
	
	<!-- First, include the Webcam.js JavaScript Library -->
	<script src="{{ URL::asset('admin/webcam.js') }}"></script>
	
	
	<!-- Configure a few settings and attach camera -->
		<script language="JavaScript">
			Webcam.set({
				width: 300,
				height: 460,
				image_format: 'jpeg',
				jpeg_quality: 90
			});
			Webcam.attach( '#my_camera' );
		</script>
	
	<!-- A button for taking snaps -->
	<form>
             <input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type=button value="Take Snapshot" onClick="take_snapshot()">
	</form>
	
	<!-- Code to handle taking the snapshot and displaying it locally -->
	<script language="JavaScript">
		function take_snapshot() {
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
				// display results in page
				
				document.getElementById('results').innerHTML = 
					'<h2>Processing:</h2>';
					
				Webcam.upload( data_uri, 'saveimage.php', function(code, text) {
					document.getElementById('results').innerHTML = 
					'<h2>Here is your image:</h2>' + 
					'<img src="'+text+'"/>';
				} );	
			} );
		}
	</script>
@endsection