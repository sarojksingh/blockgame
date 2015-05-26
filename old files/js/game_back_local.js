﻿        // Getting elements
        var pad = document.getElementById("pad");
        var ball = document.getElementById("ball");
        var svg = document.getElementById("svgRoot");
        var message = document.getElementById("message");

        // Ball
        var ballRadius = ball.r.baseVal.value;

        var ballX;
        var ballY;
        var previousBallPosition = { x: 0, y: 0 };
        var ballDirectionX;
        var ballDirectionY;
        var ballSpeed = 10;

        // Pad
        var padWidth = pad.width.baseVal.value;

        var padHeight = pad.height.baseVal.value;
        var padX;
        var padY;
        var padSpeed = 0;
        var inertia = 0.80;

        // Bricks
        var bricks = [];
        var destroyedBricksCount;
        var brickWidth = 20;
        var brickHeight = 15;
        var bricksRows = 3;
        var bricksCols = 20;
        var bricksMargin = 1;
        var bricksTop = 20;
        
        var leftBrickRowsWidth = 300;
        var leftBrickColsHeight = 200;

        // Misc.
        var minX = ballRadius;
        var minY = ballRadius;
        var maxX;
        var maxY;
        var startDate;

        // Brick function
        function Brick(x, y) {

            var isDead = false;
            var position = { x: x, y: y };

            var rect = document.createElementNS("http://www.w3.org/2000/svg", "rect");
            svg.appendChild(rect);

            rect.setAttribute("width", brickWidth);
            rect.setAttribute("height", brickHeight);
            
        // Random green color
            var chars = "456789abcdef";
            var color = "";
            for (var i = 0; i < 2; i++) {
                var rnd = Math.floor(chars.length * Math.random());
                color += chars.charAt(rnd);
            }
            // rect.setAttribute("fill", "#81" + color + "38");
            rect.setAttribute("fill", "#814f38");

            this.drawAndCollide = function () {
                if (isDead)
                    return;
                // Drawing
                rect.setAttribute("x", position.x);
                rect.setAttribute("y", position.y);
                // console.log(position);
                // Collision
                if (ballX + ballRadius < position.x || ballX - ballRadius > position.x + brickWidth)
                return;

                if (ballY + ballRadius < position.y || ballY - ballRadius > position.y + brickHeight)
                return;

                // Dead
                this.remove();
                isDead = true;
                destroyedBricksCount++;

                // Updating ball
                ballX = previousBallPosition.x;
                ballY = previousBallPosition.y;

                ballDirectionY *= -1.0;
            };

            // Killing a brick
            this.remove = function () {
            if (isDead)
                return;
                svg.removeChild(rect);
            };
        }

        // Collisions
        function collideWithWindow() {
            //alert("ballX="+ballX+"minX="+minX+"maxX="+maxX);
            if (ballX < minX) {
                ballX = minX;
                ballDirectionX *= -1.0;
            }
            else if (ballX > maxX) {
                ballX = maxX;
                ballDirectionX *= -1.0;
            }

            if (ballY < minY) {
                ballY = minY;
                ballDirectionY *= -1.0;
            }
            else if (ballY > maxY) {
                ballY = maxY;
                ballDirectionY *= -1.0;
                lost();
            }
        }

        function collideWithPad() {
            
            if (ballX + ballRadius < padX || ballX - ballRadius > padX + padWidth)
            return;

            if (ballY + ballRadius < padY)
            return;

            ballX = previousBallPosition.x;
            ballY = previousBallPosition.y;
            ballDirectionY *= -1.0;

            var dist = ballX - (padX + padWidth / 2);

            ballDirectionX = 2.0 * dist / padWidth;


            var square = Math.sqrt(ballDirectionX * ballDirectionX + ballDirectionY * ballDirectionY);
            ballDirectionX /= square;
            ballDirectionY /= square;

        }

        // Pad movement
        function movePad() {
            padX += padSpeed;

            padSpeed *= inertia;

            if (padX < minX)
                padX = minX;

            if (padX + padWidth > maxX)
                padX = maxX - padWidth;
            }

            registerMouseMove(document.getElementById("gameZone"), function (posx, posy, previousX, previousY) {
                padSpeed += (posx - previousX) * 0.2;
            });

            window.addEventListener('keydown', function (evt) {
                switch (evt.keyCode) {
                // Left arrow
                    case 37:
                        padSpeed -= 10;
                        break;
                // Right arrow   
                    case 39:
                        padSpeed += 10;
                        break;
                }
            }, true);

        function checkWindow() {
            // alert(window.innerWidth);
            maxX = 490 - minX + 300 -300;
            maxY = 490 - minY - 20;    
            padY = maxY - 25;
        }

        function gameLoop() {
            movePad();

            // Movements
            previousBallPosition.x = ballX;
            previousBallPosition.y = ballY;
            ballX += ballDirectionX * ballSpeed;
            ballY += ballDirectionY * ballSpeed;

            // Collisions
            collideWithWindow();
            collideWithPad();

            // Bricks

            for (var index = 0; index < bricks.length; index++) {
                bricks[index].drawAndCollide();
            }

            // Ball
            ball.setAttribute("cx", ballX);
            ball.setAttribute("cy", ballY);

            // Pad
            pad.setAttribute("x", padX);
            pad.setAttribute("y", padY);
            $(".score").text(destroyedBricksCount);
           // ctx.fillText("Score: " + points, 20, 20 );
            // Victory ?
            
            if (destroyedBricksCount == bricks.length) {
                win();
            }
        }

        // function updateScore(destroyedBricksCount) {
        //     var canvas = document.getElementById("backgroundCanvas");
        //     var context = canvas.getContext("2d");
        //    // alert(context);
        //     //alert(destroyedBricksCount);
        //         // context.fillStlye = "black";
        //         // context.font = "16px Arial, sans-serif";
        //         // context.textAlign = "left";
        //         // context.textBaseline = "top";
        //         // context.fillText("Score: " + destroyedBricksCount, 20, 20 );
        // }

        function generateBricks() {
            // Removing previous ones
            for (var index = 0; index < bricks.length; index++) {
                bricks[index].remove();
            }
           
            // Creating new ones
            var brickID = 0;

            var offset = (490 - bricksCols * (brickWidth + bricksMargin)) / 2.0;
                
            for (var x = 0; x < bricksCols; x++) {
                for (var y = 0; y < bricksRows; y++) {
                    bricks[brickID++] = new Brick(offset + x * (brickWidth + bricksMargin), y * (brickHeight + bricksMargin) + bricksTop);
                }  
            }
        }
        var gameIntervalID = -1;
        
        function lost() {
            // clearInterval(gameIntervalID);
            // gameIntervalID = -1;
            // $(".score").text(destroyedBricksCount);
            // message.innerHTML = "Loose! Game Over - You scored "+destroyedBricksCount+" points!";
            //alert("Game over !");
            //message.innerHTML = "Game over !";
           //message.style.visibility = "visible";
        }

        

        function win() {
            clearInterval(gameIntervalID);
            gameIntervalID = -1;

            var end = (new Date).getTime();
            $(".score").text(destroyedBricksCount);
            message.innerHTML = "Win ! Game Over - You scored "+destroyedBricksCount+" points!";
            message.style.visibility = "visible"; 
        }

        function initGame() {
            message.style.visibility = "hidden";

            checkWindow();

            padX = (490 - padWidth) / 2.0;

            ballX = 490 / 2.0;
            ballY = maxY - 60;

            previousBallPosition.x = ballX;
            previousBallPosition.y = ballY;

            padSpeed = 0;

            ballDirectionX = Math.random();
            ballDirectionY = -1.0;

            generateBricks();
            gameLoop();
        }

        function startGame() {
            initGame();

            destroyedBricksCount = 0;

            if (gameIntervalID > -1)
            clearInterval(gameIntervalID);

            startDate = (new Date()).getTime();
            gameIntervalID = setInterval(gameLoop, 16);
        }

        document.getElementById("newGame").onclick = startGame;
        window.onresize = initGame;

        initGame();