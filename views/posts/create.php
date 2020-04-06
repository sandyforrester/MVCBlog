<p>Fill in the following form to create a new blog post:</p>
<form action="" method="POST" class="w3-container" enctype="multipart/form-data">

    <h2>Create New Blog Post</h2>
</div>
<p>
    <input class="w3-input" type="text" name="userid" required autofocus>
    <label>User ID</label>
</p>
<p>
    <input class="w3-input" type="text" name="title" required autofocus>
    <label>Title</label>
</p>
<p>
    <input class="w3-input" type="text" name="blurb" required>
    <label>Blurb</label>
</p>
<p>
    <input class="w3-input" type="text" name="content" required>
    <label>Content</label>
</p>

<label>Difficulty rating:</label>
<select name="rating" required>
    <option><option value="Beginner">Beginner</option>
    <option><option value="Intermediate">Intermediate</option>
    <option><option value="Expert">Expert</option>
</select>


 <input type="hidden"  
	   name="MAX_FILE_SIZE" 
         value="10000000"  
         />  

  <input type="file" name="blogpic" class="w3-btn w3-pink" required />
<p>
    <input class="w3-btn w3-pink" type="submit" value="Create My Post!">
</p>
</form>