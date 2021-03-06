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
?>
<div class="widget worthcracy user-worthcracy">
<h3 class="title"><?php echo Text::get('profile-my_worth-header'); ?></h3>
<?php if (isset($this['amount'])) : ?>
    <div class="worth-amount"><?php echo number_format($this['amount'], 0, '',',') ?></div>
<?php endif ?>
<?php // include 'view/worth/base.html.php' ?>
</div>
