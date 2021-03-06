<?php
/*
 *  Copyright (C) 2012 Platoniq y Fundación Fuentes Abiertas (see README for details)
 *	This file is part of Goteo.
 *
 *  Goteo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Goteo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with Goteo.  If not, see <http://www.gnu.org/licenses/agpl.txt>.
 *
 */

use Goteo\Library\Text,
    Goteo\Model;

$promo = $this['promo'];

$node = isset($_SESSION['admin_node']) ? $_SESSION['admin_node'] : \GOTEO_NODE;

// proyectos disponibles
// si tenemos ya proyecto seleccionado lo incluimos
$projects = Model\Promote::available($promo->project, $node);
$status = Model\Project::status();

?>
<form method="post" action="/admin/promote">
    <input type="hidden" name="action" value="<?php echo $this['action'] ?>" />
    <input type="hidden" name="order" value="<?php echo $promo->order ?>" />
    <input type="hidden" name="id" value="<?php echo $promo->id; ?>" />

<p>
    <label for="promo-project"><?php echo Text::_('Proyecto'); ?>:</label><br />
    <select id="promo-project" name="project">
        <option value="" ><?php echo Text::_('Seleccionar el proyecto a destacar'); ?></option>
    <?php foreach ($projects as $project) : ?>
        <option value="<?php echo $project->id; ?>"<?php if ($promo->project == $project->id) echo' selected="selected"';?>><?php echo $project->name . ' ('. $status[$project->status] . ')'; ?></option>
    <?php endforeach; ?>
    </select>
</p>

<?php if ($node == \GOTEO_NODE) : ?>
<p>
    <label for="promo-name"><?php echo Text::_('Título'); ?>:</label><span style="font-style:italic;"><?php echo Text::_('Máximo 24 caracteres'); ?></span><br />
    <input type="text" name="title" id="promo-title" value="<?php echo $promo->title; ?>" maxlength="24" style="width:500px;" />
</p>

<p>
    <label for="promo-description"><?php echo Text::_('Descripción'); ?>:</label><span style="font-style:italic;"><?php echo Text::_('Máximo 100 caracteres'); ?></span><br />
    <input type="text" name="description" id="promo-description" maxlength="100" value="<?php echo $promo->description; ?>" style="width:750px;" />
</p>
<?php endif; ?>

<p>
    <label><?php echo Text::_('Publicado'); ?>:</label><br />
    <label><input type="radio" name="active" id="promo-active" value="1"<?php if ($promo->active) echo ' checked="checked"'; ?>/> <?php echo Text::_('SÍ'); ?></label>
    &nbsp;&nbsp;&nbsp;
    <label><input type="radio" name="active" id="promo-inactive" value="0"<?php if (!$promo->active) echo ' checked="checked"'; ?>/> <?php echo Text::_('NO'); ?></label>
</p>

    <input type="submit" name="save" value="<?php echo Text::get('regular-save'); ?>" />
</form>
