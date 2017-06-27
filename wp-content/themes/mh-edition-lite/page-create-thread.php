<!-- /*
 * Template Name: スレッド投稿フォーム
 */ -->
<?php get_header(); ?>
<form action="<?php the_permalink();?>" method="post">
    <?php wp_nonce_field('create_thread'); ?>
    <table class="form-table">
    <tbody>
        <tr>
            <th><label for="title">タイトル</label></th>
            <td><input id="title" type="text" name="title" value="" /></td>
        </tr>
        <tr>
            <th><label for="content">本文</label></th>
            <td><textarea id="content" name="content"></textarea></td>
        </tr>
        <tr>
            <th><label>カテゴリー</label></th>
            <td><?php wp_dropdown_categories(); ?></td>
        </tr>
        <tr>
            <th><label for="url">参考URL</label></th>
            <td><input id="url" type="text" name="url" value="" /></td>
        </tr>
    </tbody>
    </table>
    <p class="submit">
        <input type="submit" value="投稿する" />
    </p>
</form>
<?php get_footer(); ?>
