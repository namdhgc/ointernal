<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	

	
		@foreach ($data as $key => $value)
			echo <pre>
	        {{ print_r($value) }}
			
		@endforeach
        
	

	
</body>
</html>