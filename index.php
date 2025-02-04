<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index_style.css">
</head>
<body>
    <header>
        <nav>
            <a href="selection.php" class="btn">Login</a>
            <a href="r_selection.php" class="btn">Register</a>
        </nav>
    </header>

    <!-- carousel -->
    <div class="carousel">
        <!-- list item -->
        <div class="list">
            <div class="item">
                <img src="image/img1.jpg">
                <div class="content">
                    <div class="title">Welcome to HopeFull!</div>
                    <div class="topic">For Humanity. By Humanity</div>
                    <div class="des">
                        
                        Hopefull is a donation platform dedicated to making a difference by connecting generous donors with people and causes in need. Our mission is to inspire hope and create meaningful change through seamless, transparent, and impactful giving. With Hopefull, you can contribute to building stronger communities, one donation at a time, and see the real impact of your generosity.
                    </div>
                    <div class="buttons">
                        <button onclick="window.location.href='selection.php'">LOGIN</button>
                        <button onclick="window.location.href='r_selection.php'">REGISTER</button>
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="image/img2.jpeg">
                <div class="content">
                    <div class="title">DONATE</div>
                    <div class="topic">For Humanity</div>
                    <div class="des">
                        Donating is more than just giving—it’s an opportunity to make a lasting impact on lives and communities. By contributing to meaningful causes, you help provide vital resources, inspire hope, and create opportunities for growth and healing. Donations foster a sense of connection, empower those in need, and drive positive change. Whether big or small, every contribution matters, building stronger, more compassionate communities and leaving a legacy of kindness and generosity.
                    </div>
                    <div class="buttons">
                        <button onclick="window.location.href='about.php'">Learn More</button>
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="image/img3.jpg">
                <div class="content">
                    
                    <div class="title">SPREAD</div>
                    <div class="topic">Laughter & Happiness</div>
                    <div class="des">
                        Brightening the lives of schoolchildren by supporting their education and well-being.  
                        Every act of kindness brings joy and hope to their young hearts.  
                        Your support helps provide resources, opportunities, and a chance to dream.  
                        Together, we can create a brighter future, one child at a time.  
                        Let’s make learning a joyful journey and bring smiles to their faces.
                    </div>
                    <div class="buttons">
                        <button onclick="window.location.href='about.php'">Learn More</button>
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="image/img4.jpg">
                <div class="content">
                    
                    
                    <div class="title">MAKE</div>
                    <div class="topic">Their World Better</div>
                    <div class="des">
                        Hopefull empowers individuals with disabilities by providing a platform to showcase and sell their goods. Through accessible tools and a supportive community, we help them reach a wider audience, gain financial independence, and share their talents with the world. Together, we create opportunities that foster inclusion and dignity.
                    </div>
                    <div class="buttons">
                        <button onclick="window.location.href='hopefullmarketplace/login.php'">Shop</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- list thumnail -->
        <div class="thumbnail">
            <div class="item">
                <img src="image/img1.jpg">
                <div class="content">
                    <div class="title">
                        HopeFull
                    </div>
                    <div class="description">
                        For Humanity 
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="image/img2.jpeg">
                <div class="content">
                    <div class="title">
                        HopeFull
                    </div>
                    <div class="description">
                        By Humanity
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="image/img3.jpg">
                <div class="content">
                    <div class="title">
                       HopeFull
                    </div>
                    <div class="description">
                       Spread Kindness
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="image/img4.jpg">
                <div class="content">
                    <div class="title">
                        HopeFull
                    </div>
                    <div class="description">
                        Give Kindness
                    </div>
                </div>
            </div>
        </div>
        <!-- next prev -->

        <div class="arrows">
            <button id="prev"></button>
            <button id="next">></button>
        </div>
        <!-- time running -->
        <div class="time"></div>
    </div>

    <script src="js/app.js"></script>
</body>
</html>