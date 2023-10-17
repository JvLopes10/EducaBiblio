<?php
class GetLivro {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obterLivrosRecomendados() {
        $sql = "SELECT LivroRec, AutorRec, CatRec, ImgRec, CamRec FROM recomendacao";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>