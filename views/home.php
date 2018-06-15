<h2>Listes</h2>

<div id="lists" class="d-flex flex-row">
    <?php foreach ($viewVars['lists'] as $list): ?>
        <!-- Listes en colonne -->
        <div class="list" data-list-id="<?php echo $list->id ?>">
            <h3><span class="title"><?php echo $list->name; ?></span><i class="form-display fa fa-edit"></i><i class="card-add fa fa-plus-square"></i></h3>
            <form class="form-edit">
                <input type="text" class="name" name="name" value="<?php echo $list->name ?>">
                <input type="hidden" class ="id" name="id" value="<?php echo $list->id ?>">
                <button type="submit" class="btn btn-secondary btn-sm" >OK</button>
            </form>
        </div>
    <?php endforeach; ?>
    <!-- Ajout d'une liste -->
    <div id="list-add"><i class="fa fa-plus-square"></i></div>
</div>
