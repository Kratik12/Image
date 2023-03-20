<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="styles.css" />
    <title>Imge Generator</title>
  </head>
  <body>
    <?php
		  if (isset($_POST['submit'])) {
        $inputText = $_POST['inputText'];

        $ch = curl_init();

        $url = 'https://api.openai.com/v1/images/generations';
        
        $data = array(
          'prompt' => $inputText,
          'n' => 1,
          'size' => '1024x1024'
        );
        
        $headers = array(
          'Content-Type: application/json',
          'Authorization: Bearer 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',
        );
        
        $options = array(
          CURLOPT_URL => $url,
          CURLOPT_POST => true,
          CURLOPT_POSTFIELDS => json_encode($data),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER => $headers
        );
        
        curl_setopt_array($ch, $options);
        
        $response = curl_exec($ch);
        
        if(curl_errno($ch)) {
          echo 'Error: ' . curl_error($ch);
        }
        
        curl_close($ch);
        
        $response_data = json_decode($response, true);
        $image_url = $response_data['data'][0]['url'];
		  }
	  ?>
    <h1 class="heading">Image Generator</h1>
    <div>
      <form method="post">
        <input type="text" placeholder="Enter your text here" class="input" id="inputText" name="inputText">
		    <button type="submit" name="submit" class="btn">Generate</button>
	    </form>
    </div>
    <img src="<?php echo $image_url; ?>" alt="Generated Image" class="image">
  </body>
</html>
