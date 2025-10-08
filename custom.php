<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8" />
    <title>Custom Phone Case Designer</title>
    <style>
        #topBar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background-color: white;
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 20px;
            z-index: 10;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: purple;
            text-decoration: none;
            color: black;
            margin-left: 30px;
        }


        body {
            margin: 0;
            padding-top: 60px;
            display: flex;
            height: 100vh;
            font-family: sans-serif;
        }

        #sidebar {
            width: 400px;
            padding: 15px;
            padding-top: 35px;
            box-sizing: border-box;
            border-right: 1px solid #ccc;
            background-color: #f9f9f9;
            overflow-y: auto;
        }

        #imageList img {
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            cursor: pointer;
            border-radius: 6px;
        }

        #mainArea {
            flex: 1;
            position: relative;
            background-color: #eee;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #case {
            width: 300px;
            height: 600px;
            background-color: lightgray;
            position: relative;
            border-radius: 20px;
            overflow: hidden;
        }

        #cartBtn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 15px;
            background: #00bcd4;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        /* 스타일 나머지 유지 */
        .image-container {
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            transform-origin: center;
            cursor: grab;
        }

        .uploaded-image {
            display: block;
            max-width: 100%;
            max-height: 100%;
        }

        .selected {
            outline: 2px solid red;
        }

        .resize-handle {
            width: 10px;
            height: 10px;
            background-color: blue;
            position: absolute;
            cursor: nwse-resize;
        }

        .resize-handle.tl {
            top: 0;
            left: 0;
            transform: translate(-50%, -50%);
        }

        .resize-handle.tr {
            top: 0;
            right: 0;
            transform: translate(50%, -50%);
        }

        .resize-handle.bl {
            bottom: 0;
            left: 0;
            transform: translate(-50%, 50%);
        }

        .resize-handle.br {
            bottom: 0;
            right: 0;
            transform: translate(50%, 50%);
        }

        .rotate-handle {
            width: 15px;
            height: 15px;
            background-color: green;
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            cursor: pointer;
            border-radius: 50%;
        }

        .delete-button,
        .copy-button {
            position: absolute;
            top: -40px;
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
            padding: 5px;
            font-size: 12px;
        }

        .copy-button {
            left: 0;
            background-color: orange;
        }

        .delete-button {
            right: 0;
        }

        .hidden {
            display: none;
        }

        #uploadLabel {
            display: inline-block;
            width: 340px;
            padding: 10px 15px;
            margin: 10px 0;
            background: #00bcd4;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
        }

        #imageList {
            display: flex;
            flex-wrap: wrap;
            gap: 4%;
            justify-content: flex-start;
        }

        .thumbnail-wrapper {
            width: 45%;
            margin-bottom: 10px;
            box-sizing: border-box;
            position: relative;
        }

        .thumbnail-wrapper img {
            width: 100%;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 6px;
            cursor: pointer;
            padding: 3px;
        }

        .delete-icon {
            position: absolute;
            top: 8px;
            right: 3px;
            width: 20px;
            height: 20px;
            cursor: pointer;
            display: none;
        }

        .thumbnail-wrapper:hover .delete-icon {
            display: block;
        }

        .thumbnail-label {
            position: absolute;
            top: 2px;
            left: 2px;
            background-color: rgba(255, 255, 255, 0.6);
            color: white;
            font-size: 12px;
            padding: 2px 5px;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div id="topBar">
        <a href="index.php" class="logo">Luminous</a>
        <button id="cartBtn">장바구니 추가</button>
    </div>

    <div id="sidebar">
        <label for="imageInput" id="uploadLabel">이미지 업로드</label>
        <div id="fileCount" style="font-weight: bold; margin-top: 20px;">파일 (0)</div>
        <input type="file" id="imageInput" accept="image/*" style="display: none;" />
        <div id="imageList" style="display: none;"></div>

        <div id="uploadPrompt">
            <div style="text-align: center; margin-top: 250px;">
                <img src="img/Warning.png" alt="업로드 아이콘" style="width: 60px; opacity: 0.6;" />
                <p style="font-weight: bold; margin: 10px 0 4px;">파일을 업로드하세요.</p>
                <p style="font-size: 12px; color: #666;">드래그 앤 드롭하거나 업로드 버튼을 사용하세요.<br />JPG, SVG, PNG</p>
            </div>
        </div>
    </div>


    <div id="mainArea">
        <div id="case"></div>
    </div>

    <script>
        const caseElement = document.getElementById('case');
        const imageInput = document.getElementById('imageInput');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    addThumbnail(e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });


        let imageCount = 0;

        function addThumbnail(src) {
            imageCount++;

            const uploadPrompt = document.getElementById('uploadPrompt');
            const imageList = document.getElementById('imageList');
            const fileCount = document.getElementById('fileCount');

            // 안내 숨기고 섹션 보이게
            uploadPrompt.style.display = 'none';
            imageList.style.display = 'flex';

            // 파일 (N) 업데이트
            fileCount.textContent = `파일 (${imageCount})`;

            // 썸네일 생성
            const wrapper = document.createElement('div');
            wrapper.className = 'thumbnail-wrapper';

            const thumb = document.createElement('img');
            thumb.src = src;

            // 삭제 아이콘 생성
            const deleteIcon = document.createElement('img');
            deleteIcon.src = 'img/delete.png';
            deleteIcon.className = 'delete-icon';
            deleteIcon.style.width = '30px';
            deleteIcon.style.height = '30px';

            deleteIcon.addEventListener('click', (e) => {
                e.stopPropagation(); // 썸네일 클릭 방지
                imageList.removeChild(wrapper);
                imageCount--;
                fileCount.textContent = `파일 (${imageCount})`;

                if (imageCount === 0) {
                    uploadPrompt.style.display = 'block';
                    imageList.style.display = 'none';
                }
            });

            wrapper.appendChild(thumb);
            wrapper.appendChild(deleteIcon);

            wrapper.addEventListener('click', () => {
                const newContainer = createImage(src);
            });

            imageList.appendChild(wrapper);
        }


        function createImage(src, posX = 50, posY = 50, width = 100, height = 100, rotation = 0) {
            const container = document.createElement('div');
            container.className = 'image-container';
            container.style.width = width + 'px';
            container.style.height = height + 'px';


            let rotationAngle = rotation;
            let currentX = posX;
            let currentY = posY;

            const img = document.createElement('img');
            img.src = src;
            img.className = 'uploaded-image';
            container.appendChild(img);

            const deleteButton = document.createElement('button');
            deleteButton.className = 'delete-button hidden';
            deleteButton.textContent = 'Delete';
            container.appendChild(deleteButton);

            const copyButton = document.createElement('button');
            copyButton.className = 'copy-button hidden';
            copyButton.textContent = 'Copy';
            container.appendChild(copyButton);

            const rotateHandle = document.createElement('div');
            rotateHandle.className = 'rotate-handle hidden';
            container.appendChild(rotateHandle);

            ['tl', 'tr', 'bl', 'br'].forEach(handle => {
                const resizeHandle = document.createElement('div');
                resizeHandle.className = `resize-handle ${handle} hidden`;
                container.appendChild(resizeHandle);

                resizeHandle.addEventListener('mousedown', function(ev) {
                    ev.preventDefault();
                    ev.stopPropagation();
                    const rect = container.getBoundingClientRect();
                    const caseRect = caseElement.getBoundingClientRect();
                    const initWidth = rect.width;
                    const initHeight = rect.height;
                    const initX = ev.clientX;
                    const initY = ev.clientY;

                    const originX = handle.includes('l') ? rect.right : rect.left;
                    const originY = handle.includes('t') ? rect.bottom : rect.top;
                    const offsetX = originX - rect.left;
                    const offsetY = originY - rect.top;

                    function onMouseMove(e) {
                        const deltaX = e.clientX - initX;
                        const deltaY = e.clientY - initY;

                        let scaleX = handle.includes('l') ? -1 : 1;
                        let scaleY = handle.includes('t') ? -1 : 1;

                        let newWidth = initWidth + deltaX * scaleX;
                        let newHeight = initHeight + deltaY * scaleY;

                        if (e.shiftKey) {
                            const aspectRatio = initWidth / initHeight;
                            if (Math.abs(deltaX) > Math.abs(deltaY)) {
                                newHeight = newWidth / aspectRatio; // 비율을 유지
                            } else {
                                newWidth = newHeight * aspectRatio; // 비율을 유지
                            }
                        }
                        // 크기 제한 (최소 30px로 설정)
                        newWidth = Math.max(30, newWidth);
                        newHeight = Math.max(30, newHeight);

                        // 이동 보정 (기준점 유지)
                        const offsetX = (handle.includes('l') ? 1 : 0);
                        const offsetY = (handle.includes('t') ? 1 : 0);

                        const newLeft = originX - newWidth * offsetX;
                        const newTop = originY - newHeight * offsetY;
                        currentX = newLeft - caseRect.left;
                        currentY = newTop - caseRect.top;

                        // 컨테이너 크기 변경
                        container.style.width = `${newWidth}px`;
                        container.style.height = `${newHeight}px`;
                        // 이미지 크기 변경
                        const img = container.querySelector('img');
                        img.style.width = `${newWidth}px`;
                        img.style.height = `${newHeight}px`;

                        container.style.transform = `translate(${currentX}px, ${currentY}px) rotate(${rotationAngle}deg)`;
                    }

                    function onMouseUp() {
                        document.removeEventListener('mousemove', onMouseMove);
                        document.removeEventListener('mouseup', onMouseUp);
                    }

                    document.addEventListener('mousemove', onMouseMove);
                    document.addEventListener('mouseup', onMouseUp);
                });


            });

            container.addEventListener('click', function(ev) {
                ev.stopPropagation();
                document.querySelectorAll('.image-container').forEach(c => {
                    c.classList.remove('selected');
                    c.querySelectorAll('.resize-handle').forEach(h => h.classList.add('hidden'));
                    c.querySelector('.delete-button').classList.add('hidden');
                    c.querySelector('.copy-button').classList.add('hidden');
                    c.querySelector('.rotate-handle').classList.add('hidden');
                });
                container.classList.add('selected');
                container.querySelectorAll('.resize-handle').forEach(h => h.classList.remove('hidden'));
                deleteButton.classList.remove('hidden');
                copyButton.classList.remove('hidden');
                rotateHandle.classList.remove('hidden');
            });

            deleteButton.addEventListener('click', () => {
                caseElement.removeChild(container);
            });

            copyButton.addEventListener('click', () => {
                createImage(
                    src,
                    currentX + 20,
                    currentY + 20,
                    container.offsetWidth,
                    container.offsetHeight,
                    rotationAngle
                );
            });

            rotateHandle.addEventListener('mousedown', function(ev) {
                ev.preventDefault();
                const rect = container.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                let startAngle = Math.atan2(ev.clientY - centerY, ev.clientX - centerX);

                function onMouseMove(e) {
                    const currentAngle = Math.atan2(e.clientY - centerY, e.clientX - centerX);
                    const angleDelta = currentAngle - startAngle;
                    rotationAngle += angleDelta * (180 / Math.PI);
                    container.style.transform = `translate(${currentX}px, ${currentY}px) rotate(${rotationAngle}deg)`;
                    startAngle = currentAngle;
                }

                function onMouseUp() {
                    document.removeEventListener('mousemove', onMouseMove);
                    document.removeEventListener('mouseup', onMouseUp);
                }

                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
            });

            container.addEventListener('mousedown', function(ev) {
                if (
                    ev.target.classList.contains('resize-handle') ||
                    ev.target.classList.contains('rotate-handle')
                ) return;

                if (!container.classList.contains('selected')) return;

                const rect = container.getBoundingClientRect();
                const clickX = ev.clientX - rect.left;
                const clickY = ev.clientY - rect.top;

                function onMouseMove(e) {
                    const rect = caseElement.getBoundingClientRect();
                    currentX = e.clientX - rect.left - clickX;
                    currentY = e.clientY - rect.top - clickY;
                    container.style.transform = `translate(${currentX}px, ${currentY}px) rotate(${rotationAngle}deg)`;
                }

                function onMouseUp() {
                    document.removeEventListener('mousemove', onMouseMove);
                    document.removeEventListener('mouseup', onMouseUp);
                }

                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
            });

            container.addEventListener('dragstart', e => e.preventDefault());

            container.style.transform = `translate(${currentX}px, ${currentY}px) rotate(${rotationAngle}deg)`;
            caseElement.appendChild(container);

            return container;
        }



        document.addEventListener('click', function() {
            document.querySelectorAll('.image-container').forEach(c => {
                c.classList.remove('selected');
                c.querySelectorAll('.resize-handle').forEach(h => h.classList.add('hidden'));
                c.querySelector('.delete-button').classList.add('hidden');
                c.querySelector('.copy-button').classList.add('hidden');
                c.querySelector('.rotate-handle').classList.add('hidden');
            });
        });
    </script>
</body>

</html>