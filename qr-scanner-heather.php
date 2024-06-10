<!DOCTYPE html>
<html>
<head>
    <title>Camera Capture</title>
</head>
<body>
    <video id="video" width="400" height="300" autoplay></video>
    <canvas id="canvas" width="400" height="300"></canvas>

    <script>
    // Get references to video and canvas elements
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    // Access the camera stream
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                // Set the video source and start playing
                video.srcObject = stream;
                video.play();
            })
            .catch(function (error) {
                console.error('Error accessing the camera', error);
            });
    }

    // Capture the video frame and draw it on the canvas
    function captureFrame() {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
    }

    // Call the captureFrame function repeatedly
    setInterval(captureFrame, 100); // Adjust the interval as needed
</script>

</body>
</html>
