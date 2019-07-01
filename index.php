
<?
$sqlconstr = getenv('SQLAZURECONNSTR_DB_CONN_STR');
$param_array = explode(';',$sqlconstr);
$dsn_array = array();
foreach($param_array as $param) {
    $dsn_array[explode('=',$param)[0]] = explode('=',$param)[1];
}

$serverName = preg_split( '/\:|,/', $dsn_array['Server'] );

$connectionOptions = array(
    "Database" => $dsn_array['Initial Catalog'], // update me
    "Uid" => $dsn_array['User ID'], // update me
    "PWD" => $dsn_array['Password'] // update me
);
$conn = sqlsrv_connect($serverName[1], $connectionOptions);
$tsql = "SELECT DB_NAME() as [dbname]";
$getResults= sqlsrv_query($conn, $tsql);
echo ("Reading data from table" . PHP_EOL);
if ($getResults == FALSE) 
    echo (sqlsrv_errors());
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
 echo "Welcome to database: ".$row['dbname'];
}
sqlsrv_free_stmt($getResults);
?>
<style>
    table {
        border: 1px solid black;
    }
    tr {
        border: 1px solid black;
    }
	td {
        border: 1px solid black;
    }
</style>
<? 
$tsql = "SELECT TOP (1000) [CustomerID],[NameStyle],[Title],[FirstName],[MiddleName],[LastName],[Suffix],[CompanyName],[SalesPerson],[EmailAddress],[Phone] FROM [SalesLT].[Customer]";
$getResults= sqlsrv_query($conn, $tsql);
echo '<table><tr><td>CustomerID</td><td>NameStyle</td><td>Title</td><td>FirstName</td><td>MiddleName</td><td>LastName</td><td>Suffix</td><td><CompanyName/td><td>SalesPerson</td><td>EmailAddress</td><td>Phone</td></tr>';
if ($getResults == FALSE) 
    echo (sqlsrv_errors());
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
 echo "<tr>";
 	echo "<td>".$row['CustomerID']."</td>";
	echo "<td>".$row['NameStyle']."</td>";
	echo "<td>".$row['Title']."</td>";
	echo "<td>".$row['FirstName']."</td>";
	echo "<td>".$row['MiddleName']."</td>";
	echo "<td>".$row['LastName']."</td>";
	echo "<td>".$row['Suffix']."<td>";
	echo "<td>".$row['CompanyName']."</td>";
	echo "<td>".$row['EmailAddress']."</td>";
	echo "<td>".$row['Phone']."</td>";
 echo "</tr>"; 
}
echo "</table>";

sqlsrv_free_stmt($getResults);
?>