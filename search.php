<?php

    include ("assets/config/db_config.php");
    include ("assets/classes/SearchResultsProvider.php");

    if (isset($_GET["term"])){
        $term = $_GET["term"];
    }
    else 
    {
        exit("You must enter a search term.");
    }

    $type = isset($_GET["type"]) ? $_GET["type"] : "sites"; //if type in url is not then by default it gets set to "sites"
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>

    <div class="wrapper searchResultsPage">

        <div class="header">

            <div class="headerContent">

                <div class="logoContainer">
                    
                    <a href="index.php">
                        <img id="DoodleLogo" src="assets/logo/DoodleLogo.png" alt="Google">
                    </a>

                </div>

                <div class="searchContainer">

                    <form action="search.php" method="get">

                        <div class="searchBarContainer">

                            <input class="searchBox" type="text" name="term" value="<?php echo isset($term) ? $term : ''  ?>">
                            <button type="submit" class="searchButton">
                                <img src="assets/icons/searchIcon.png" alt="Search"/>
                            </button>

                        </div>



                    </form>

                </div>

            </div>

                <div class="tabsContainer">
                    <ul class="tabList">
                        <li class="<?php echo $type == 'sites' ? 'active' : '' ?>">
                            <a href='<?php echo "search.php?term=$term&type=sites"; ?>'>
                                Sites
                            </a>
                        </li>
                        <li class="<?php echo $type == 'images' ? 'active' : '' ?>">
                            <a href='<?php echo "search.php?term=$term&type=images"; ?>'>
                                Images
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

    </div>



    <div class="mainResultsSection">

        <?php

            global $connection;
            $pageSize = 20;

            $resultsProvider = new SearchResultsProvider($connection);

            $numResults = $resultsProvider->getNumOfResults($term);

            echo "<p class='resultsCount'>$numResults results found</p>";

            echo $resultsProvider->getResultsHtml($page, $pageSize ,$term);
        ?>

    </div>

    <div class="paginationContainer">

        <div class="pageButtons">

            <div class="pageNumberContainer">
                <img src="assets/logo/BlueD.png" alt="D">
            </div>

            <?php 

                $pagesToShow = 10;
                $numOfPages = ceil($numResults / $pageSize);
                $currentPage = $page - floor($pagesToShow / 2);
                

                $pagesLeft = min($pagesToShow, $numOfPages);

                if ($currentPage < 1) $currentPage = 1;

                if ($currentPage + $pagesLeft > $numOfPages + 1) $currentPage = $numOfPages + 1 - $pagesLeft;

                while($pagesLeft > 0 && $currentPage <= $numOfPages){


                    if ($currentPage == $page) echo "<div class='pageNumberContainer'>
                                                        <img src='assets/logo/RedO.png'>
                                                        <span class='pageNumber'>$currentPage</span>
                                                    </div>";
                    
                    
                    else echo "<div class='pageNumberContainer'>
                                    <a href='search.php?term=$term&type=$type&page=$currentPage'>
                                        <img src='assets/logo/YellowO.png'>
                                        <span class='pageNumber'>$currentPage</span>
                                    </a>
                                </div>";

                    
                    $currentPage++;
                    $pagesLeft--;
                }
            ?>

            <div class="pageNumberContainer">
                <img src="assets/logo/dle.png" alt="DLE">
            </div>

        </div>

        

    </div>


</body>

</html>