<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost"; $usuario = "root"; $contrasenia = ""; $nombreBaseDatos = "nameDatabase";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);

// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultar"])){
    $data = json_decode(file_get_contents("php://input"));
    $username=$data->username;
    $password=$data->password;
    // $sqlUsuarios = mysqli_query($conexionBD,"SELECT * FROM user_register WHERE username='$username' AND password='$password'");
    if(($password!="")&&($username!="")){
        $sqlUsuarios = mysqli_query($conexionBD,"SELECT * FROM user_register WHERE username='$username' AND password='$password'");
        class Result {}
        $response = new Result();
        if($sqlUsuarios->num_rows>0){
            $response->resultado = 'OK';
            $response->mensaje = 'login success';
        }else{
            $response->resultado = 'FAIL';
            $response->mensaje = 'login fail';
        }

            header('Content-Type: application/json');
            echo json_encode($response);  
        // if($username = mysqli_fetch_assoc($sqlUsuarios)){
        //     echo json_encode(["success"=>$data]);
        // }
    }else{
        echo json_encode(["success"=>0]);
    }
        exit();
}

//Inserta un nuevo registro y recepciona en método post los datos de nombre y contrasenia
if(isset($_GET["insertarRegistro"])){
    $data = json_decode(file_get_contents("php://input"));
    $username=$data->username;
    $mail=$data->mail;
    $years=$data->years;
    $password=$data->password;
    $password2=$data->password2;
        if(($password!="")&&($username!="")){
            
    $sqlUsuarios = mysqli_query($conexionBD,"INSERT INTO user_register(username,mail,years,password,password2) VALUES('$username','$mail','$years','$password','$password2') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}
#
if(isset($_GET["insertarPalabra"])){
    $data = json_decode(file_get_contents("php://input"));
    $word=$data->word;
    $meaning=$data->meaning;
    $example_sentence=$data->example_sentence;
        if(($word!="")&&($meaning!="")){
            
    $sqlUsuarios = mysqli_query($conexionBD,"INSERT INTO libro(cod_libro,titulo,anio) VALUES('$word','$meaning','$example_sentence') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}

    //Consulta todos los registros de la tabla basic_vocabulary
    if(isset($_GET["consultarPalabras"])){
    // $sqlUsuarios = mysqli_query($conexionBD,"SELECT * FROM basic_vocabulary");
    $data = json_decode(file_get_contents("php://input"));
    $username=$data->username;
    $password=$data->password;
    $sqlUsuarios = mysqli_query($conexionBD,"SELECT * FROM libro AS li INNER JOIN libro_autor 
    AS la ON li.cod_libro=la.cod_libro INNER JOIN
    autor AS au ON la.cod_autor=au.cod_autor
    WHERE au.nom_autor='Gardarin'");
    if ($resultado = mysqli_fetch_array($sqlUsuarios)){
        $datos[] = $resultado;
        echo json_encode($datos);
    }else{
        echo json_encode([["success"=>0]]);
    }

    
    // if(mysqli_num_rows($sqlUsuarios) > 0){
    //     $username = mysqli_fetch_all($sqlUsuarios,MYSQLI_ASSOC);
    //     echo json_encode($username);
    // }
    // else{ echo json_encode([["success"=>0]]); }
    }

    //Consultar en recommended_content
    if(isset($_GET["consultarRecomendado"])){
        $sqlUsuarios = mysqli_query($conexionBD,"SELECT * FROM rec_content");
        if(mysqli_num_rows($sqlUsuarios) > 0){
            $username = mysqli_fetch_all($sqlUsuarios,MYSQLI_ASSOC);
            echo json_encode($username);
        }
        else{ echo json_encode([["success"=>0]]); }
        }
// $sqlUsuarios = mysqli_query($conexionBD,"SELECT * FROM user_register ");
// $iteraciones=mysqli_num_rows($sqlUsuarios);
// while($fila=mysqli_fetch_array($sqlUsuarios)){
//     if($username==$sqlUsuarios['username']&&$password==$sqlUsuarios['password']){
        
//     }
// }


?>