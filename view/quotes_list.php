<!DOCTYPE html>
<html>
<head>
    <title>JS Quotes</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<main>
    <body>
        <div id="intro">
        <h1 style="font-size: 250%;">Jake Staab's Quotes</h1>
        <p style="font-size: 75%">(written by other, more famous people)</p>
        </div><br>
        <div class="">
                <form>
                    <input type="hidden" name="action" value="order_by">
                    <select name="authorId">
                        <option value="0">View All Authors</option>
                        <?php foreach ($authors as $author) { ?>
                            <option value="<?php echo $author['id']; ?>">
                                <?php echo $author['author']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <select name="categoryId">
                        <option value="0">View All Categories</option>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category['id']; ?>">
                                <?php echo $category['category']; ?>
                            </option>
                        <?php } ?>
                    </select>

                    <input class="" type="submit" value="Submit" />
                </form>
            </div>

        <table>
            <?php foreach($posts_arr['data'] as $r) {
                $quote = $r['quote'];
                $author = $r['author_name'];
                $category = $r['category_name'];
            ?>
            <tr>
                <td class="quote"><?php echo $quote ?></td>
                <td class="category"><?php echo $category ?></td>
            </tr>
            <tr>
                <td class="author"><?php echo $author ?></td>
                
            </tr>
            <?php } ?>
        </table>
    </body>
</main>
</html>