<?php

require_once("includes/classes/Entity.php");

    class PreviewProvider {
        private $con;
        private $username;

        public function __construct($con, $username) {
            $this->con = $con;
            $this->username = $username;
        }

        public function createPreviewVideo($entity) {
            // create random entity
            if($entity == null) {
                $entity = $this->getRandomEntity();
            }

            $id = $entity->getId();
            $name = $entity->getName();
            $thumbnail = $entity->getThumbnail();
            $preview = $entity->getPreview();

            return 
                "<div class='previewContainer'>
                
                    <img class='previewImage' src='$thumbnail' hidden>
                    <video autoplay muted class='previewVideo' onended='previewEnded()'>
                        <source src='$preview' type='video/mp4'>
                    </video>

                    <div class='previewOverlay'>
                        <div class='mainDetails'>
                            <h3>$name</h3>
                            <div class='buttons'>
                                <button> <i class='fas fa-play'></i> Play </button>
                                <button onclick='volumeToggle(this)'> <i class='fas fa-volume-mute'></i></button>
                            </div>
                        </div>
                    </div>

                </div>";

        }

        private function getRandomEntity() {
            // select random entity
            $query = $this->con->prepare("SELECT * FROM entities ORDER BY RAND() LIMIT 1");
            $query->execute();

            $row = $query->fetch(PDO::FETCH_ASSOC);

            return new Entity($this->con, $row);
           
        }
    }

?>