<nav class="tab-bar">
    <section class="left-small nav-left-strip">
        <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
    </section>
    <section class="middle tab-bar-section"><a href="<?= base_url() ?>"><img class="nav_logo" src="<?= base_url('assets/img/logos/logo_white.png')?>" alt=""></a></section>
</nav>

<aside class="left-off-canvas-menu">
    <ul class="off-canvas-list">
        <li <?php echo $active_menu == 'dashboard' ? 'class="active"':''; ?>><a href="<?= base_url() ?>">Dashboard</a></li>
<?php
if( $this->session->userdata('sess_dept') <= 2 ) {
?>
    <li <?php echo $active_menu == 'in' ? 'class="active"':''; ?>><a href="#" class="off-canvas-submenu-call">Internal <span class="right"> + </span></a></li>
    <ul class="off-canvas-submenu no-bullet" <?php echo $active_menu == 'in' ? 'style="display:block;"':''; ?>>
        <li <?php echo $active_submenu == 'jo' ? 'class="active"':''; ?>><a href="<?= base_url('jo?id=' . $this->session->userdata('sess_id')) ?>">Job Order</a></li>
        <li <?php echo $active_submenu == 'production' ? 'class="active"':''; ?>><a href="<?= base_url('jo/Production') ?>">Production</a></li>
        <li <?php echo $active_submenu == 'mvrf' ? 'class="active"':''; ?>><a href="<?= base_url('jo/mvrf') ?>">Manpower / Vehicle Request Form</a></li>
        <li <?php echo $active_submenu == 'setup' ? 'class="active"':''; ?>><a href="<?= base_url('jo/setup') ?>">Set Up</a></li>
        <li <?php echo $active_submenu == 'activations' ? 'class="active"':''; ?>><a href="<?= base_url('jo/activations') ?>">Activations</a></li>
        <li <?php echo $active_submenu == 'instore' ? 'class="active"':''; ?>><a href="<?= base_url('jo/instore') ?>">In-store</a></li>
        <li <?php echo $active_submenu == 'accounts' ? 'class="active"':''; ?>><a href="<?= base_url('jo/accounts_n') ?>">accounts</a></li>
    </ul>
    <li <?php echo $active_menu == 'ex' ? 'class="active"':''; ?>><a href="#" class="off-canvas-submenu-call">External <span class="right"> + </span></a></li>
    <ul class="off-canvas-submenu no-bullet">
        <li <?php echo $active_submenu == 'motm' ? 'class="active"':''; ?>><a href="<?= base_url('jo/motm') ?>">Minutes of the meeting</a></li>
        <li <?php echo $active_submenu == 'bd' ? 'class="active"':''; ?>><a href="<?= base_url('jo/bd') ?>">Bid Deck</a></li>
        <li <?php echo $active_submenu == 'ppld' ? 'class="active"':''; ?>><a href="<?= base_url('jo/ppld') ?>">Pre - prod and logistics</a></li>
        <li <?php echo $active_submenu == 'wrd' ? 'class="active"':''; ?>><a href="<?= base_url('jo/wrd') ?>">Weekly report</a></li>
        <li <?php echo ($active_submenu == 'iped' || $active_submenu == 'fped') ? 'class="active"':''; ?>><a href="#" class="off-canvas-submenu-call">Post Evaluation <span class="right"> + </span></a></li>

        <ul class="off-canvas-submenu no-bullet">
            <li <?php echo $active_submenu == 'iped' ? 'class="active"':''; ?>><a href="<?= base_url('jo/iped') ?>">Initial</a></li>
            <li <?php echo $active_submenu == 'fped' ? 'class="active"':''; ?>><a href="<?= base_url('jo/fped') ?>">Final</a></li>
        </ul>
        <li><a href="<?= base_url() ?>">In-store</a></li>
    </ul>
    <li <?php echo $active_menu == 'clients' ? 'class="active"':''; ?>><a href="<?= base_url('jo/clients'); ?>">Clients</a></li>
        <?php
            if( $this->session->userdata('sess_role') == 'admin' ){
		?>
				<li <?php echo $active_menu == 'emp' ? 'class="active"':''; ?>><a href="<?php echo base_url('emp'); ?>">Employees</a></li>
		<?php
            }
        ?>

        <hr />
        <li <?php echo $active_menu == 'references' ? 'class="active"':''; ?>><a href="<?=base_url('jo/references');?>">References</a></li>
<?php
}
?>
        <li <?php echo $active_menu == 'settings' ? 'class="active"':''; ?>><a href="<?=base_url('settings');?>">Settings</a></li>
        <li><a href="<?=base_url('home/logout');?>">Logout</a></li>

        <!--    For dropdown    -->
        <li class="hide"><a href="#" class="off-canvas-submenu-call">Option 4 <span class="right"> + </span></a></li>
        <ul class="off-canvas-submenu">
            <li><a href="#">Sub menu 1</a></li>
            <li><a href="#">Sub menu 2</a></li>
            <li><a href="#">Sub menu 3</a></li>
        </ul>

    </ul>
</aside>