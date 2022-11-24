<li class="menu-header">Main Menu</li>
<li ><a class="nav-link" href="<?=site_url("/")?>"><i class="fa fa-fire"></i> <span>Dashboard</span></a></li>

<li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown"><i class="far fa-address-book"></i><span>User</span></a>
    <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?=site_url('manage-user')?>">Autentikasi</a></li>
        <li><a class="nav-link" href="<?=site_url('manage-mahasiswa')?>">Mahasiswa</a></li>
        <li><a class="nav-link" href="<?=site_url('manage-orang-tua')?>">Orang Tua</a></li>
    </ul>
</li>

<li ><a class="nav-link" href="<?=site_url("manage-berita")?>"><i class="far fa-newspaper"></i> <span>Berita</span></a></li>
<li ><a class="nav-link" href="<?=site_url("manage-galeri")?>"><i class="fas fa-images"></i> <span>Galeri</span></a></li>

<li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-money-bill-wave"></i><span>Keuangan</span></a>
    <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?=site_url('manage-keuangan')?>">Set Keuangan</a></li>
        <li><a class="nav-link" href="<?=site_url('manage-')?>">Pembayaran</a></li>
        <li><a class="nav-link" href="<?=site_url('manage-')?>">Pengeluaran</a></li>
    </ul>
</li>

<li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown">
        <!-- <i class="fas fa-chalkboard-teacher"></i> -->
        <i class="fas fa-chalkboard"></i>
        <span>E-learning</span></a>
    <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?=site_url('manage-')?>">Kelas</a></li>
        <li><a class="nav-link" href="<?=site_url('manage-')?>">Bank Soal</a></li>
    </ul>
</li>


<li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-envelope"></i> <span>Undangan</span></a>
    <ul class="dropdown-menu">
        <li><a class="nav-link" href="layout-default.html">Set Udangan</a></li>
        <li><a class="nav-link" href="layout-transparent.html">Riwaya Undangan</a></li>        
    </ul>
</li>
