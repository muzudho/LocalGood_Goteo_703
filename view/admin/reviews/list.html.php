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

use Goteo\Library\Text;

$filters = $this['filters'];

?>
<div class="widget board">
<form id="filter-form" action="/admin/reviews" method="get">
   
    <label for="project-filter"><?php echo Text::_('Del proyecto'); ?>:</label>
    <select id="project-filter" name="project" onchange="document.getElementById('filter-form').submit();">
        <option value="">--</option>
        <?php foreach ($this['projects'] as $projId=>$projName) : ?>
            <option value="<?php echo $projId; ?>"<?php if ($filters['project'] == $projId) echo ' selected="selected"';?>><?php echo substr($projName, 0, 100); ?></option>
        <?php endforeach; ?>
    </select>

    <br />

    <label for="status-filter"><?php echo Text::_('Mostrar por estado'); ?>:</label>
    <select id="status-filter" name="status" onchange="document.getElementById('filter-form').submit();">
        <option value=""><?php echo Text::_('Todas'); ?></option>
    <?php foreach ($this['status'] as $statusId=>$statusName) : ?>
        <option value="<?php echo $statusId; ?>"<?php if ($filters['status'] == $statusId) echo ' selected="selected"';?>><?php echo $statusName; ?></option>
    <?php endforeach; ?>
    </select>

    <label for="checker-filter"><?php echo Text::_('Asignados a'); ?>:</label>
    <select id="checker-filter" name="checker" onchange="document.getElementById('filter-form').submit();">
        <option value=""><?php echo Text::_('De todos'); ?></option>
    <?php foreach ($this['checkers'] as $checker) : ?>
        <option value="<?php echo $checker->id; ?>"<?php if ($filters['checker'] == $checker->id) echo ' selected="selected"';?>><?php echo $checker->name; ?></option>
    <?php endforeach; ?>
    </select>
</form>
</div>

<?php if (!empty($this['list'])) : ?>
    <?php foreach ($this['list'] as $project) : ?>
        <div class="widget board">
            <table>
                <thead>
                    <tr>
                        <th width="30%"><?php echo Text::_("Proyecto"); ?></th> <!-- edit -->
                        <th width="20%"><?php echo Text::_("Creador"); ?></th> <!-- mailto -->
                        <th width="7%">%</th> <!-- segun estado -->
                        <th width="8%"><?php echo Text::_('Puntos'); ?></th> <!-- segun estado -->
                        <th width="7%">
                            <!-- Iniciar revision si no tiene registro de revision -->
                            <!-- Editar si tiene registro -->
                        </th>
                        <th width="10%"><!-- Ver informe si tiene registro --></th>
                        <th width="8%"><!-- Cerar si abierta --></th>
                        <th width="12%"></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><a href="/project/<?php echo $project->project; ?>" target="_blank" title="Preview"><?php echo $project->name; ?></a></td>
                        <td><?php echo $project->owner; ?></td>
                        <td><?php echo $project->progress; ?></td>
                        <td><?php echo $project->score . ' / ' . $project->max; ?></td>
                        <?php if (!empty($project->review)) : ?>
                        <td><a href="/admin/reviews/edit/<?php echo $project->project; ?>">[<?php echo Text::_("Editar"); ?>]</a></td>
                        <td><a href="/admin/reviews/report/<?php echo $project->project; ?>" target="_blank">[<?php echo Text::_("Ver informe"); ?>]</a></td>
                            <?php if ( $project->status > 0 ) : ?>
                        <td><a href="/admin/reviews/close/<?php echo $project->review; ?>">[<?php echo Text::_("Cerrar"); ?>]</a></td>
                            <?php else : ?>
                        <td><?php echo Text::_('Revisión cerrada'); ?></td>
                            <?php endif; ?>
                        <?php else : ?>
                        <td><a href="/admin/reviews/add/<?php echo $project->project; ?>">[<?php echo Text::_("Iniciar revision"); ?>]</a></td>
                        <td></td>
                        <?php endif; ?>
                        <td><?php if ($project->translate) : ?><a href="<?php echo "/admin/translates/edit/{$project->project}"; ?>">[<?php echo Text::_("Ir a traducción"); ?>]</a>
                        <?php else : ?><a href="<?php echo "/admin/translates/add/?project={$project->project}"; ?>">[<?php echo Text::_("Habilitar traducción"); ?>]</a><?php endif; ?></td>


                    </tr>
                </tbody>

            </table>

            <?php if (!empty($project->review)) : ?>
            <table>
                <tr>
                    <th><?php echo Text::_('Revisor'); ?></th>
                    <th><?php echo Text::_('Puntos'); ?></th>
                    <th><?php echo Text::_('Listo'); ?></th>
                    <th></th>
                </tr>
                <?php foreach ($project->checkers as $user=>$checker) : ?>
                <tr>
                    <td><?php echo $checker->name; ?></td>
                    <td><?php echo $checker->score . '/' . $checker->max; ?></td>
                    <td><?php if ($checker->ready) : ?><?php echo Text::_('Listo '); ?><a href="/admin/reviews/unready/<?php echo $project->review; ?>/?user=<?php echo $user; ?>">[<?php echo Text::_("Reabrir"); ?>]</a><?php endif ?></td>
                    <td><a href="/admin/reviews/unassign/<?php echo $project->review; ?>/?user=<?php echo $user; ?>">[<?php echo Text::_("Desasignar"); ?>]</a></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($project->status > 0) : ?>
                <tr>
                    <form id="form-assign-<?php echo $project->review; ?>" action="/admin/reviews/assign/<?php echo $project->review; ?>/" method="get">
                    <td colspan="2">
                        <select name="user">
                            <option value=""><?php echo Text::_('Selecciona un nuevo revisor'); ?></option>
                            <?php foreach ($this['checkers'] as $user) :
                                if (in_array($user->id, array_keys($project->checkers))) continue;
                                ?>
                            <option value="<?php echo $user->id; ?>"><?php echo $user->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><a href="#" onclick="document.getElementById('form-assign-<?php echo $project->review; ?>').submit(); return false;">[<?php echo Text::_("Asignar"); ?>]</a></td>
                    </form>
                </tr>
                <?php endif; ?>
            </table>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>
<?php else : ?>
<p><?php echo Text::_("No se han encontrado registros"); ?></p>
<?php endif; ?>