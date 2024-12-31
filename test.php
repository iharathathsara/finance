<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Picture</title>
</head>

<body>
    <h1>Take a Profile Picture</h1>
    <button id="openCamera">Profile Picture</button>
    <video id="video" width="320" height="240" autoplay></video>
    <button id="capture">Capture Photo</button>
    <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
    <img id="photo" alt="Profile Picture">
    <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data" style="display: none;">
        <input type="hidden" name="image" id="imageData">
        <input type="submit" value="Upload Photo">
    </form>

    <script src="script.js"></script>
    <script>
        document.getElementById('openCamera').addEventListener('click', function() {
            const video = document.getElementById('video');
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function(stream) {
                    video.srcObject = stream;
                })
                .catch(function(err) {
                    console.error("Error: " + err);
                });
        });

        document.getElementById('capture').addEventListener('click', function() {
            const canvas = document.getElementById('canvas');
            const video = document.getElementById('video');
            const context = canvas.getContext('2d');

            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL('image/png');

            document.getElementById('photo').src = dataURL;
            document.getElementById('imageData').value = dataURL;
            document.getElementById('uploadForm').style.display = 'block';
        });
    </script>
</body>

</html>