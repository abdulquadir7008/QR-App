<!DOCTYPE html>
<html>
<head>
    <title>Camera Example</title>
    <style>
        #canvas {
            border: 1px solid black;
            display: none;
        }
    </style>
</head>
<body>
    <h1>Camera Example</h1>
    <video id="video" width="640" height="480" autoplay></video>
    <canvas id="canvas" width="640" height="480"></canvas>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');

        function handleSuccess(stream) {
            video.srcObject = stream;
            video.play();
        }

        function handleError(error) {
            console.error('Error accessing the camera.', error);
            const errorMessage = document.createElement('p');
            errorMessage.textContent = 'Error accessing the camera. Please make sure you have a camera connected and have granted access.';
            document.body.appendChild(errorMessage);
        }

        // Access the user's camera and stream the video
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            const constraints = { video: true };

            navigator.mediaDevices.getUserMedia(constraints)
                .then(handleSuccess)
                .catch(handleError);
        } else {
            console.error('getUserMedia is not supported');
            const errorMessage = document.createElement('p');
            errorMessage.textContent = 'Sorry, your browser does not support accessing the camera.';
            document.body.appendChild(errorMessage);
        }

        // Capture a frame from the video stream and draw it on the canvas
        function captureFrame() {
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            requestAnimationFrame(captureFrame);
        }

        // Start capturing frames
        video.addEventListener('play', function() {
            captureFrame();
        });
    </script>
</body>
</html>
