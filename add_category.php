<?php
$con = mysqli_connect("localhost","root","","alok")or die('connection failed');

if(isset($_POST['submit']))
{
    $parent        =$_POST['parent_id'];
    $category_name =$_POST['name'];
    
    $ins = mysqli_query($con,"insert into category values('','$category_name','$parent')");
    if($ins)
    {
        $msg = "<span style='color:green;font-weight:bolder;'>Category successfully saved</span>";
        header("location.href=add_category.php");
    }
   
}

?>
<html>
<head>
    <title>Assignment - Categories Solution</title>
    
</head>
<body>
    <form method="post">
        <table border="1" align="center" width="50%">
           <tr>
               <th colspan="2"> <?php echo @$msg; ?> </th> 
           </tr>
            <tr>
               <th colspan="2">Category SubCategory</th> 
           </tr>
            <tr>
               <th>Parent</th>
                <th>Category Name</th>

            </tr>
            <tr>
              <td>
                   <select name="parent_id">
                       <option value="0">Select Parent</option>
                       <?php
                         $query = mysqli_query($con,"select * from category");
                         $arr=mysqli_fetch_all($query);
                         foreach($arr as $cat)
                         {
                          ?>
                            <option value="<?=$cat[0]?>"> <?php echo $cat[1]; ?> </option>
                          <?php
                         }
                       ?>

                   </select>
               </td>
              <td> <input type="text" name="name" value="" placeholder="Category Name"> </td>
            </tr>
            <tr>
               <th colspan="2"> <input type="submit" name="submit" value="save"> </th> 
           </tr>
        </table>
    </form>
    
    <hr><hr>
    
    <?php
$query=mysqli_query($con,"select * from category where parent_id='0'");
$arr=mysqli_fetch_all($query);
echo '<ol>';
foreach($arr as $val)
{
  ?>
   <li> <?php echo $val[1]; ?>
        <?php  echo getChild($con,$val[0]);  ?>
   </li>
  <?php
    
}
echo '</ol>';


function getChild($con,$id)
{
    $query = mysqli_query($con,"select *  from category where parent_id='$id'"); //for get child
    $rows=mysqli_num_rows($query);
    if($rows > 0) // child present
    {
        $childs=mysqli_fetch_all($query);
        echo '<ol>';
        foreach($childs as $child)
        {
         echo '<li>'.$child[1].'</li>';
            getChild($con,$child[0]);
        }
        echo '</ol>';
    }
    else // child  not present
    {
        return false;
    }
}

?>
    
    
</body>    
</html>