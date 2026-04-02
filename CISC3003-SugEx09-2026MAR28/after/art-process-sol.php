<?php
// 使用 $_POST 超全局数组获取POST数据
$title = isset($_POST['title']) ? $_POST['title'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$genre = isset($_POST['genre']) ? $_POST['genre'] : '';
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
$medium = isset($_POST['medium']) ? $_POST['medium'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';
$museum = isset($_POST['museum']) ? $_POST['museum'] : '';
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <title>CISC3003 Suggested Exercise 09</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="js/misc.js"></script>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php include 'header.inc.php'; ?>
    
<main>
    <section class="results">
    
    <table>
      <caption class="results__caption">Art Work Saved</caption>
      <tr>
        <td class="results__label">Title</td>    
        <td class="results__value"><?php echo htmlspecialchars($title); ?></td> 
      </tr>
      <tr>
        <td class="results__label">Description</td>    
        <td class="results__value"><?php echo htmlspecialchars($description); ?></td> 
      </tr>
      <tr>
        <td class="results__label">Genre</td>    
        <td class="results__value"><?php echo htmlspecialchars($genre); ?></td> 
      </tr>
      <tr>
        <td class="results__label">Subject</td>    
        <td class="results__value"><?php echo htmlspecialchars($subject); ?></td> 
      </tr>
      <tr>
        <td class="results__label">Medium</td>    
        <td class="results__value"><?php echo htmlspecialchars($medium); ?></td> 
      </tr>   
      <tr>
        <td class="results__label">Year</td>    
        <td class="results__value"><?php echo htmlspecialchars($year); ?></td> 
      </tr>  
      <tr>
        <td class="results__label">Museum</td>    
        <td class="results__value"><?php echo htmlspecialchars($museum); ?></td> 
      </tr>          
    </table>
    
    </section>
</main>       
</body>
</html>