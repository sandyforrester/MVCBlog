<div class="row">
    <div class="leftcolumn">
        <div class="card">
            <table>
                <?php
                if (!empty($posts)) {
                    echo '<p>Our posts containing your search results are listed below: </p>';
                    foreach ($posts as $post):
                        echo '<tr>';
                        echo '<div>';
                        echo '<h1><a href="?controller=post&action=read&id=' . $post->postid . '">' . $post->title . '</a></h1>';
                        echo '<p>Posted on ' . ($post->created) . '</p>';
                        echo '<p>' . $post->blurb . '</p>';
                        echo '<button><a href="?controller=post&action=read&id=' . $post->postid . '">Read More</a></button>';
                        echo '<p><br/></p>';
                        echo '</div>';

                        echo '</tr>';
                    endforeach;
                }
                elseif (empty($posts)) {
                    echo "Sorry! We couldn't find any blog content containing your search term.";
                }
                ?>
            </table>
        </div>
    </div>
    <div class="rightcolumn">
        <div class="card">
            <h2>Events Calendar</h2>
            <div class="fakeimg" style="height:100px;">Put in the calendar here</div>

        </div>
        <div class="card">
            <h3>Card for something else:</h3>
            <div class="fakeimg">Image link to a post</div><br>
            <div class="fakeimg">Image link to a post</div><br>
            <div class="fakeimg">Image link to a post</div>
        </div>
        <div class="card">
            <h3>Follow Us</h3>
            <p>Link to our social media</p>
        </div>
    </div>
</div>