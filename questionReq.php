<?php
    session_start();
    include('pdo.php');

    if(!empty($_POST)){
        $reponses = "";

        foreach($_POST as $cle => $val){
            $reponses .= $val . ",";
        }

        $reponses = substr($reponses, 0, strlen($reponses)-1);

        $stmt=$pdo->prepare("INSERT INTO reponsecandidat(idCandidat, idQuestion, reponses, dateReponse)
        VALUES (:idCandidat, :idQuestion, :reponses, :dateReponse)", 
        array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stmt->execute(
            array(
                ':idCandidat'=>$_SESSION['idCandidat'],
                ':idQuestion'=>$_SESSION['idQuestion'],
                ':reponses'=>$reponses,
                ':dateReponse'=>date("Y-m-d")
            )
        );

        $stmt->closeCursor();

        $_SESSION['ordreQuestion']++;
        header('Location:question.php');
    }else{
        header('Location:question.php');
        exit();
    }
?>