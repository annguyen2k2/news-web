<?php
if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $postValueId){
        $bulk_options = $_POST['bulk_options'];
        switch($bulk_options){
            case 'public':
                $query = "UPDATE post SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                $update_to_published_status = mysqli_query($connection, $query);
                comfirm($update_to_published_status);
                break;
            case 'draft':
                $query = "UPDATE post SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                $update_to_draft_status = mysqli_query($connection, $query);
                comfirm($update_to_draft_status);
            case 'delete':
                $query = "DELETE FROM post WHERE post_id = {$postValueId} ";
                $update_to_delete_post = mysqli_query($connection, $query);
                comfirm($update_to_delete_post);    
                header("Location: posts.php");
                
        }
    } 
}
?>
<form action="" method='post'>
<table class="table table-bordered table-hover">
                <div id="bulkOptionContainer" class="col-xs-4">
                <select class="form-control" name="bulk_options" id="">
                <option value="">Select Option</option>
                <option value="public">Public</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                </select>
                </div>
                <div class="col-xs-4">
                <input type="submit" value="Apply" name="submit" class="btn btn-success">
                <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
                </div>
                            <thead>
                                <tr>
                                    <th><input id="selectAllBoxes" type="checkbox"></th>
                                    <th>ID</th>
                                    <th>Author</th>
                                    <th>Title</th>
                                    <th>Post description</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>View Post</th>
                                    <th>View Post Number</th>
                                    <th>Comment</th>
                                    <th>Date</th>
                                    <th>Delete</th>
                                    <th>Update</th>
                                    <th>Change to public</th>
                                    <th>Change to Draft</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $query = "SELECT * FROM post";
                                    $select_all_posts = mysqli_query($connection, $query);
                                    while($row = mysqli_fetch_assoc($select_all_posts))
                                    {
                                    $post_id            = $row['post_id'];
                                    $post_author        = $row['post_author'];
                                    $post_title         = $row['post_title'];
                                    $post_des           = $row['post_description'];
                                    $post_content       = $row['post_content'];
                                    $post_category_id   = $row['post_category_id'];
                                    $post_status        = $row['post_status'];
                                    $post_image         = $row['post_image'];
                                    $post_tags          = $row['post_tags'];
                                    $post_comment_count = $row['post_comment_count'];
                                    $post_date          = $row['post_date'];
                                    $post_views_count   = $row['post_views_count'];
                                    echo "<tr>";
                                    ?>
                                    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
                                    <?php
                                    echo "<td>$post_id</td>";
                                    echo "<td>$post_author</td>";
                                    echo "<td>$post_title</td>";
                                    echo "<td>$post_des</td>";


                                    $query = "SELECT * FROM category WHERE cat_id = {$post_category_id}";
                                    $select_by_category_id = mysqli_query($connection, $query);
                                    comfirm($select_by_category_id);
                                    while($row = mysqli_fetch_assoc($select_by_category_id))
                                    {
                                    $cat_title = $row['cat_title'];
                                    $cat_id = $row['cat_id'];
                                    echo "<td>{$cat_title}</td>";
                                    }
                                   
                                    echo "<td>$post_status</td>";
                                    echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
                                    echo "<td>$post_tags</td>";
                                    echo "<td><a href='../post.php?p_id={$post_id}'>View</a></td>";
                                    echo " <td><a href='posts.php?reset=$post_id'>{$post_views_count}</a></td>";
                                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
                                    $send_comment_query = mysqli_query($connection,$query);
                                    // $row = mysqli_fetch_array($send_comment_query);
                                    // $comment_id = $row['comment_id'];
                                    $count_comment = mysqli_num_rows($send_comment_query);
                                    echo "<td><a href='post_comment.php?id=$post_id'>$count_comment</a></td>";
                                    echo "<td>$post_date</td>";
                                    echo "<td><a onClick=\"javascript:return confirm('Are you sure you want to delete'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
                                    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                                    echo " <td><a href='posts.php?change_to_public=$post_id'>Public</a></td>";
                                    echo " <td><a href='posts.php?change_to_draft=$post_id'>Draft</a></td>";
                                    echo "</tr>";
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                        </form>
                        <?php 
                      if(isset($_GET['change_to_public']))
                      {
                          $the_public_id = $_GET['change_to_public'];
                          $query = "UPDATE post SET post_status = 'public' WHERE post_id = {$the_public_id}";
                          $update_query = mysqli_query($connection, $query);
                          header("Location: posts.php");
                         comfirm($update_query);
                      }
                      if(isset($_GET['change_to_draft']))
                      {
                          $the_draft_id = $_GET['change_to_draft'];
                          $query = "UPDATE post SET post_status = 'draft' WHERE post_id = {$the_draft_id}";
                          $update_query = mysqli_query($connection, $query);
                          header("Location: posts.php");
                         comfirm($update_query);
                      }
                     ?>
                     <?php 
                     if(isset($_GET['delete']))
                     {
                         $the_post_id = $_GET['delete'];
                         $query = "DELETE FROM post WHERE post_id = {$the_post_id}";
                         $delete_query = mysqli_query($connection, $query);
                         header("Location: posts.php");
                        //  if(!$delete_query){
                        //      die("QUERY FAILED" . mysqli_error($connection));
                        //  }
                        comfirm($delete_query);
                     }
                     if(isset($_GET['reset']))
                     {
                         $the_reset_id = $_GET['reset'];
                         $query = "UPDATE post SET post_views_count = 0 WHERE post_id = {$the_reset_id}";
                         $reset_query = mysqli_query($connection, $query);
                         header("Location: posts.php");
                        //  if(!$delete_query){
                        //      die("QUERY FAILED" . mysqli_error($connection));
                        //  }
                        comfirm($reset_query);
                     }
                     ?>