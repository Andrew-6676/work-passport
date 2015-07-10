<?php
/**
 * Created by PhpStorm.
 * User: frenzy
 * Date: 26.02.15
 * Time: 10:29
 */



function import_consumer(){
    $sql = "SELECT * FROM topgas_classifier.consumers";
    $res = mysql_query($sql);
    $i = 0;
    $arr = array();
    while($row = mysql_fetch_array($res)){
        $arr[$i]["idConsumer"] = $row["idConsumer"];
        $arr[$i]["idOwnership"] = $row["idOwnership"];
        $arr[$i]["idSubjHoz"] = $row["idSubjHoz"];
        $arr[$i]["idArea"] = $row["idArea"];
        $arr[$i]["idMinRB"] = $row["idMinRB"];
        $arr[$i]["idTap"] = $row["idTap"];
        $arr[$i]["idIndustry"] = $row["idIndustry"];
        $arr[$i]["nameConsumer"] = $row["nameConsumer"];
        $arr[$i]["address"] = $row["address"];
        $arr[$i]["note"] = $row["note"];
        $arr[$i]["gasified"] = $row["gasified"];
        $arr[$i]["lastUpdate"] = $row["lastUpdate"];
        $arr[$i]["dateClose"] = $row["dateClose"];
        $arr[$i]["str1"] = $row["str1"];
        $arr[$i]["str2"] = $row["str2"];
        $arr[$i]["str3"] = $row["str3"];
        $arr[$i]["str4"] = $row["str4"];
        $arr[$i]["nrt"] = $row["nrt"];
        $arr[$i]["vxr"] = $row["vxr"];
        $arr[$i]["edr"] = $row["edr"];
        $arr[$i]["tex"] = $row["tex"];
        $arr[$i]["passport"] = $row["passport"];
        $arr[$i]["largeUser"] = $row["largeUser"];
        $arr[$i]["codeConsumer"] = $row["codeConsumer"];
        $arr[$i]["idTown"] = $row["idTown"];
        $arr[$i]["combyt"] = $row["combyt"];
        $arr[$i]["privileged"] = $row["privileged"];
        $arr[$i]["budgetary"] = $row["budgetary"];
        $arr[$i]["ownNeeds"] = $row["ownNeeds"];
        $arr[$i]["isKolhoz"] = $row["isKolhoz"];
    }

    for($j=0; $j<count($arr); $j++){
        if (mysql_num_rows(mysql_query("SELECT * FROM gasb.consumer WHERE consumer.codeConsumer=".$arr[$j]["codeConsumer"])) == 0){
                mysql_query("INSERT INTO obj (id_obj, id_type_obj) VALUES (null, 35)");
                mysql_query("SET @lastID := LAST_INSERT_ID()");
                        $sql = "INSERT INTO consumer (
                            `id_obj`, `idConsumer`, `idOwnership`, `idSubjHoz`, `idArea`, `idMinRB`, `idTap`, `idIndustry`, `nameConsumer`, `address`, `note`, `gasified`, `lastUpdate`,
                            `dateClose`, `str1`, `str2`, `str3`, `str4`, `nrt`, `vxr`, `edr`, `tex`, `passport`, `largeUser`, `codeConsumer`, `idTown`, `combyt`, `privileged`, `budgetary`,
                            `ownNeeds`, `isKolhoz`
                        ) VALUES (@lastID,
                        ".$arr[$j]['idConsumer'].",
                        ".$arr[$j]['idOwnership'].",
                        ".$arr[$j]['idSubjHoz'].",
                        ".$arr[$j]['idArea'].",
                        ".$arr[$j]['idMinRB'].",
                        ".$arr[$j]['idTap'].",
                        ".$arr[$j]['idIndustry'].",
                        '".$arr[$j]['nameConsumer']."',
                        ".$arr[$j]['address'].",
                        ".$arr[$j]['note'].",
                        ".$arr[$j]['gasified'].",
                        ".$arr[$j]['lastUpdate'].",

                        ".$arr[$j]['dateClose'].",
                        ".$arr[$j]['str1'].",
                        ".$arr[$j]['str2'].",
                        ".$arr[$j]['str3'].",
                        ".$arr[$j]['str4'].",
                        ".$arr[$j]['nrt'].",
                        ".$arr[$j]['vxr'].",
                        ".$arr[$j]['edr'].",
                        ".$arr[$j]['tex'].",
                        ".$arr[$j]['passport'].",
                        ".$arr[$j]['largeUser'].",
                        ".$arr[$j]['codeConsumer'].",
                        ".$arr[$j]['idTown'].",
                        ".$arr[$j]['combyt'].",
                        ".$arr[$j]['privileged'].",
                        ".$arr[$j]['budgetary'].",
                        ".$arr[$j]['ownNeeds'].",
                        ".$arr[$j]['isKolhoz'].")";
                        mysql_query($sql);
        }else{
            $sql = "UPDATE consumer SET
                       idConsumer=".$arr[$j]['idConsumer'].",
                       idOwnership = ".$arr[$j]['idOwnership'].",
                       idSubjHoz = ".$arr[$j]['idSubjHoz'].",
                       idArea = ".$arr[$j]['idArea'].",
                       idMinRB = ".$arr[$j]['idMinRB'].",
                       idTap = ".$arr[$j]['idTap'].",
                       idIndustry = ".$arr[$j]['idIndustry'].",
                       nameConsumer = '".$arr[$j]['nameConsumer']."',
                       address = ".$arr[$j]['address'].",
                       note = ".$arr[$j]['note'].",
                       gasified = ".$arr[$j]['gasified'].",
                       lastUpdate = ".$arr[$j]['lastUpdate'].",
                       dateClose = ".$arr[$j]['dateClose'].",
                       str1 = ".$arr[$j]['str1'].",
                       str2 = ".$arr[$j]['str2'].",
                       str3 = ".$arr[$j]['str3'].",
                       str4 = ".$arr[$j]['str4'].",
                       nrt = ".$arr[$j]['nrt'].",
                       vxr = ".$arr[$j]['vxr'].",
                       edr = ".$arr[$j]['edr'].",
                       tex = ".$arr[$j]['tex'].",
                       passport = ".$arr[$j]['passport'].",
                       largeUser = ".$arr[$j]['largeUser'].",
                       idTown = ".$arr[$j]['idTown'].",
                       combyt = ".$arr[$j]['combyt'].",
                       privileged = ".$arr[$j]['privileged'].",
                       budgetary = ".$arr[$j]['budgetary'].",
                       ownNeeds = ".$arr[$j]['ownNeeds'].",
                       isKolhoz = ".$arr[$j]['isKolhoz']." WHERE codeConsumer=".$arr[$j]["codeConsumer"]."
            ";
            mysql_query($sql);
        }
    }
}





    $con = mysql_connect('localhost','topgas_c_usr','topgas_c_pass');
    mysql_select_db('topgas_classifier',$con);
    if(!con) die("No mysql connection");

    import_consumer();
?>