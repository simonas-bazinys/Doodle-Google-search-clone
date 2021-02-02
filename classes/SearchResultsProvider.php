<?php 
    class SearchResultsProvider {

        private $connection;

        public function __construct($connection)
        {
            $this->connection = $connection;
        }

        public function getNumOfResults($term)
        {
            // count of links, descriptions, titles etc where search term appears in any way
            // example: term = cat, possible result = Catch the latest music tracks. Catch word contains "cat". Not always very accurate
            $query = $this->connection->prepare("SELECT COUNT(*) AS TOTAL 
                                                FROM sites 
                                                WHERE title LIKE :term 
                                                    OR url LIKE :term 
                                                    OR description LIKE :term 
                                                    OR keywords LIKE :term");


            $searchTerm = "%" . $term . "%";  // the word might appear in the middle of another word. Example: Cats - would not fit the criteria. So we use %term%        
            $query->bindParam(":term", $searchTerm);
            $query->execute();

            $row = $query->fetch(PDO::FETCH_ASSOC); //store query resuls in associative key-value array

            return $row["TOTAL"];
        }

        public function getResultsHtml($page, $pageSize, $term){
            
            $fromLimit = $page * $pageSize - $pageSize;

            $query = $this->connection->prepare("SELECT *
                                                FROM sites 
                                                WHERE title LIKE :term 
                                                    OR url LIKE :term 
                                                    OR description LIKE :term 
                                                    OR keywords LIKE :term
                                                ORDER BY clicks DESC
                                                LIMIT :fromLimit, :pageSize");


            $searchTerm = "%" . $term . "%";  // the word might appear in the middle of another word. Example: Cats - would not fit the criteria. So we use %term%
            
            $query->bindParam(":fromLimit", $fromLimit, PDO::PARAM_INT);
            $query->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
            $query->bindParam(":term", $searchTerm);
            $query->execute();

            $resultsHTML = "<div class='searchResults'>";

            while ($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $id = $row["id"];
                $url = $row["url"];
                $title = $row["title"];
                $description = $row["description"];

                $url = $this->trimField($url, 55);
                $title = $this->trimField($title, 55);
                $description = $this->trimField($description, 230);
                
                

                $resultsHTML .= "<div class='resultContainer'>
                                    <h3 class='resultTitle'>
                                        <a class='resultLink' href='$url' data-linkId='$id'>
                                            $title
                                        </a>
                                    </h3>   
                                    <span class='resultUrl'>$url</span>
                                    <span class='resultDescription'>$description</span>
                                    </div>";
            }

            $resultsHTML .= "</div>";

            return $resultsHTML;
        }

        private function trimField($string, $characterLimit) {
            
            if (strlen($string) > $characterLimit)
            {
                $string = substr($string,0, $characterLimit) . "...";
            }

            return $string;
        }

    }
?>