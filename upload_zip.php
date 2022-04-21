<?php
if (isset($_FILES['file'])) {
    if ($_FILES['file']['error'] == 0) {
        if ($_FILES['file']['type'] == 'application/x-zip-compressed') {
            $zip = new ZipArchive;
            $res = $zip->open($_FILES['file']['tmp_name']);
            if ($res === TRUE) {
                $zip->extractTo(
                    str_replace(
                        '.zip',
                        '',
                        strtolower($_FILES['file']['name'])
                    ) . '/'
                );
                $zip->close();
                echo "<div style='font-size:40px; height: 80vh; text-align:center; line-height: 80vh'>Upload Successful<div>";;
            } else {
                echo "<div style='font-size:40px; height: 80vh; text-align:center; line-height: 80vh'>Upload Failed! Check the format again<div>";
            }
        } else {
            echo "<div style='font-size:40px; height: 80vh; text-align:center; line-height: 80vh'>Not a Zip File<div>";
        }
    } else {
        echo "<div style='font-size:40px; height: 80vh; text-align:center; line-height: 80vh'>No files<div>";
    }
} else {?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload file</title>
    <style>
        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        html,
        body {
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            position: relative;
            margin: 0px;
            padding: 0px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgb(231, 0, 255);
            background: linear-gradient(146deg, rgba(231, 0, 255, 1) 0%, rgb(3, 231, 205) 98%);
        }

        .form-upload {
            width: 90vw;
            max-height: 600px;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.25);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 20px;
            display: block;
        }

        .form-upload .select-file {
            margin: 20px;
            border: 3px dashed rgb(218, 218, 218);
            border-radius: 10px;
            padding: 50px 0;
        }

        .form-upload .select-file svg {
            height: 150px;
            width: 100%;
            text-align: center;
        }

        .form-upload .select-file h3 {
            text-align: center;
            font-weight: 900;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-transform: uppercase;
            color: snow;
            letter-spacing: .15em;
            text-shadow: 1px 1px 5px #213;
        }

        .form-upload .select-file p {
            padding: 0 30px;
            text-align: left;
            color: rgb(32, 3, 51);
            font-family: 'Courier New', Courier, monospace;
            max-height: 100px;
            overflow: auto;
        }

        .form-upload .select-file p::-webkit-scrollbar {
            width: 0;
        }

        .form-upload input {
            display: none;
        }

        .submit {
            display: block;
            text-align: center;
            padding: 15px;
            background: rgb(231, 0, 255);
            background: linear-gradient(-146deg, rgba(231, 0, 255, 1) 0%, rgb(0, 226, 200) 98%);
            margin: 20px;
            border-radius: 100px;
            text-transform: uppercase;
            color: snow;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 900;
            font-size: 2em;
            letter-spacing: .5em;
            text-shadow: 2px 2px 3px #ccc;
            position: relative;
            cursor: pointer;
        }
        .submit::after {
            content: "";
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            border-radius: 100px;
            z-index: -1;
            background: snow;
            transform: scale(1);


        }

        .input {
            cursor: pointer;
        }
        .submit:hover::after {
            transform: scale(1.3, 1.5);
            opacity: 0;
            transition: transform .5s, opacity .7s;
        }

        .mess {
            
            width: 100vw;
            height: 100vh;
            position: fixed;
            background: #000a;
            z-index: 10000;
            top: 0;
            left: 0;
            transition: background .2s linear;
        }

        #mess:checked~.mess {
            background: #0000;
            pointer-events: none;
        }

        .mess iframe {
            background: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80vw;
            height: 80vh;
        }

        #mess:checked~.mess iframe {
            display: none;
        }

        .mess iframe body {
            background: tomato;
        }

        .view_table {
            position: absolute;
            top: 2rem;
            bottom: 2rem;
            left: 2rem;
            right: 2rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.5);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            padding: 20px;
            padding-top: 0px;
        }

        .view_table h4 {
            color: white;
            font-size: 30px;
            text-align: center;
            padding: 0;
            margin: 0;
            margin-top: 10px;
        }

        .view_list {
            flex: 1;
            overflow: auto;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .view_list::-webkit-scrollbar {
            width: 0;
        }

        .item {
            display: flex;
            justify-content: space-evenly;
            padding: 3px;
            margin: 10px;
            flex-wrap: wrap;
            border: white 1px solid;
            border-radius: 5px;

        }

        .item h5 {
            flex: 1;
            text-align: left;
        }

        .item div {
            display: flex;
        }

        .item * {
            text-align: center;
            margin: 5px;
        }

        .item button,
        .close button {
            height: 30px;
            padding: 5px 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
            outline: none;
            border: none;
            border-radius: 5px;
            color: rgb(255, 255, 255);
            font-weight: bold;
            cursor: pointer;
        }

        .item button:hover {
            transition: all .5s;
            transform: scale(1.1);
        }

        .item .copy {
            background: rgb(0, 153, 255);
        }

        .item .view {
            background: rgb(100, 100, 100);
        }

        .item .delete {
            background: rgb(228, 6, 6);
        }

        a {
            text-decoration: none;
            color: white;
            display: flex;
            height: 100%;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        button svg,
        a svg {
            height: 100%;
            width: 100%;
        }

        .search {
            margin: 10px;
            position: relative;
            right: 0;
        }

        .search label {
            text-transform: uppercase;
            font-weight: bold;
        }

        .search input {
            width: 200px;
            outline: none;
            padding: 5px;
            border: none;
            border-radius: 5px;
        }

        .close button {
            height: 60px;
            background: none;
            margin: 0;
            margin-left: auto;
            width: 260px;
            font-size: 40px;
        }

        .messenbox {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .messenbox::before {
            content: "";
            display: block;
            width: 100%;
            height: 100%;
            position: absolute;
            background: rgb(255, 255, 255);
            filter: blur(50px);
        }

        .messenbox iframe {
            width: 80%;
            height: 80%;
            z-index: 200;
            border: none;
            border-radius: 10px;
            box-shadow: 2px 2px 4px black;
            background: white;
            display: block;
            padding: 10px;
        }

        .hide {
            display: none;
        }

        .close-view {
            position: fixed;
            z-index: 10;
            height: 30px;
            width: 30px;
            top: 3%;
            right: 3%;
            color: rgb(219, 19, 19);
            cursor: pointer;

        }
    </style>
</head>

<body>
    <form target="src" class="form-upload" action="upload_zip.php" method="POST" enctype="multipart/form-data">
        <div class="select-file">
            <label for="file" class="input">
                <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="cloud-upload" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-cloud-upload fa-w-20 fa-7x">
                    <g class="fa-group">
                        <path fill="rgba(256,256,256,.6)" d="M537.6 226.6A96.11 96.11 0 0 0 448 96a95.51 95.51 0 0 0-53.3 16.2A160 160 0 0 0 96 192c0 2.7.1 5.4.2 8.1A144 144 0 0 0 144 480h368a128 128 0 0 0 25.6-253.4zm-139.9 63.7l-10.8 10.8a24.09 24.09 0 0 1-34.5-.5L320 266.1V392a23.94 23.94 0 0 1-24 24h-16a23.94 23.94 0 0 1-24-24V266.1l-32.4 34.5a24 24 0 0 1-34.5.5l-10.8-10.8a23.9 23.9 0 0 1 0-33.9l92.7-92.7a23.9 23.9 0 0 1 33.9 0l92.7 92.7a24 24 0 0 1 .1 33.9z" class="fa-secondary"></path>
                        <path fill="white" d="M397.7 290.3l-10.8 10.8a24.09 24.09 0 0 1-34.5-.5L320 266.1V392a23.94 23.94 0 0 1-24 24h-16a23.94 23.94 0 0 1-24-24V266.1l-32.4 34.5a24 24 0 0 1-34.5.5l-10.8-10.8a23.9 23.9 0 0 1 0-33.9l92.7-92.7a23.9 23.9 0 0 1 33.9 0l92.7 92.7a24 24 0 0 1 .1 33.9z" class="fa-primary"></path>
                    </g>
                </svg>
                <h3>choose file to upload</h3>
                <input type="file" name="file" id="file" accept="application/x-zip-compressed">
            </label>
            <p id="messen">
            </p>
        </div>
        <label onclick="$('#mess').checked = false" for="submit" class="submit">
            UPLOAD
        </label>
        <input type="submit" hidden id="submit">
    </form>
    <input type="checkbox" checked id="mess" hidden>
    <label for='mess' class="mess">
        <iframe name="src" frameborder="0" style="border-radius:1rem">

        </iframe>
    </label>
    <script>
        const $ = document.querySelector.bind(document);
        var files;
        $("#file").onchange = e => {
            files = e.srcElement.files;
            if (files.length > 0) {
                var mes = `Số lượng file: ${files.length}<hr>`
                for (let i = 0; i < files.length; i++) {
                    const item = files[i];
                    mes +=
                        `&#9672; File ${i + 1}: "${item.name}", ${(item.size / 1024).toFixed(2)}KB.<br>`;
                }
                $('#messen').innerHTML = mes + "<hr>";
            } else {
                $('#messen').innerHTML = "";
            }
        }
    </script>
</body>

</html>
<?php } ?>