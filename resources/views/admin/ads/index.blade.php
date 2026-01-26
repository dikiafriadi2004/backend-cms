@extends('layouts.admin')

@section('title', 'Manajemen Iklan')

@section('content')
<div class="modern-container">
    <div class="container-fluid">
        <!-- Modern Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title">Manajemen Iklan</h1>
                    <p class="page-subtitle">Dashboard profesional untuk mengelola semua jenis iklan dengan mudah</p>
                </div>
                <a href="{{ route('admin.ads.create') }}" class="btn-modern">
                    <i class="fas fa-plus"></i>
                    Tambah Iklan Baru
                </a>
            </div>
        </div>

        <!-- Modern Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-icon primary">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="stat-number">{{ $adSpaces->total() }}</div>
                <div class="stat-label">Total Iklan</div>
            </div>

            <div class="stat-card success">
                <div class="stat-icon success">
                    <i class="fas fa-play-circle"></i>
                </div>
                <div class="stat-number">{{ $adSpaces->where('status', true)->count() }}</div>
                <div class="stat-label">Iklan Aktif</div>
            </div>

            <div class="stat-card info">
                <div class="stat-icon info">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-number">{{ number_format($adSpaces->sum('view_count')) }}</div>
                <div class="stat-label">Total Views</div>
            </div>

            <div class="stat-card warning">
                <div class="stat-icon warning">
                    <i class="fas fa-mouse-pointer"></i>
                </div>
                <div class="stat-number">{{ number_format($adSpaces->sum('click_count')) }}</div>
                <div class="stat-label">Total Clicks</div>
            </div>
        </div>

        <!-- Modern Data Table -->
        <div class="data-table-card">
            <div class="table-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="table-title">Daftar Iklan</h3>
                    <p class="table-subtitle">Kelola dan monitor performa semua iklan</p>
                </div>
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Cari iklan..." id="searchInput">
                </div>
            </div>

            @if($adSpaces->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Iklan</th>
                                <th>Tipe</th>
                                <th>Posisi</th>
                                <th>Status</th>
                                <th>Performa</th>
                                <th>Jadwal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($adSpaces as $ad)
                            <tr>
                                <td>
                                    <div class="ad-info">
                                        <div class="ad-thumbnail">
                                            @if($ad->type === 'manual_banner' && $ad->image_url)
                                                <img src="{{ $ad->image_url }}" alt="{{ $ad->alt_text }}">
                                            @else
                                                <div class="ad-icon {{ $ad->type }}">
                                                    <i class="fas fa-{{ 
                                                        $ad->type === 'manual_text' ? 'link' : 
                                                        ($ad->type === 'adsense' ? 'google' : 
                                                        ($ad->type === 'adsera' ? 'code' : 'image')) 
                                                    }}"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ad-details">
                                            <h6>{{ $ad->name }}</h6>
                                            @if($ad->title)
                                                <small>{{ Str::limit($ad->title, 40) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-modern {{ 
                                        $ad->type === 'manual_banner' ? 'primary' : 
                                        ($ad->type === 'manual_text' ? 'success' : 
                                        ($ad->type === 'adsense' ? 'warning' : 'info')) 
                                    }}">
                                        {{ \App\Models\AdSpace::TYPES[$ad->type] ?? $ad->type }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ \App\Models\AdSpace::POSITIONS[$ad->position] ?? $ad->position }}
                                    </small>
                                    @if($ad->width && $ad->height)
                                        <br><small class="text-muted">{{ $ad->width }}×{{ $ad->height }}px</small>
                                    @endif
                                </td>
                                <td>
                                    @if($ad->isActive())
                                        <span class="status-badge active">
                                            <i class="fas fa-check-circle"></i>
                                            Aktif
                                        </span>
                                    @elseif($ad->isExpired())
                                        <span class="status-badge expired">
                                            <i class="fas fa-times-circle"></i>
                                            Kedaluwarsa
                                        </span>
                                    @else
                                        <span class="status-badge inactive">
                                            <i class="fas fa-pause-circle"></i>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="performance-metrics">
                                        <div class="metric-row">
                                            <span class="metric-label">Views:</span>
                                            <span class="metric-value">{{ number_format($ad->view_count) }}</span>
                                        </div>
                                        <div class="metric-row">
                                            <span class="metric-label">Clicks:</span>
                                            <span class="metric-value">{{ number_format($ad->click_count) }}</span>
                                        </div>
                                        <div class="metric-row">
                                            <span class="metric-label">CTR:</span>
                                            <span class="ctr-value">{{ $ad->getClickThroughRate() }}%</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($ad->start_date)
                                        <small class="text-muted">
                                            <i class="fas fa-play text-success"></i>
                                            {{ $ad->start_date->format('d/m/Y') }}
                                        </small>
                                    @endif
                                    @if($ad->end_date)
                                        <br><small class="text-muted">
                                            <i class="fas fa-stop text-danger"></i>
                                            {{ $ad->end_date->format('d/m/Y') }}
                                        </small>
                                    @else
                                        <small class="text-primary">
                                            <i class="fas fa-infinity"></i>
                                            Permanen
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.ads.edit', $ad) }}" 
                                           class="btn-action btn-edit" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit Iklan">
                                            <i class="fas fa-edit"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>
                                        
                                        <a href="{{ route('admin.ads.analytics', $ad) }}" 
                                           class="btn-action btn-analytics" 
                                           data-bs-toggle="tooltip" 
                                           title="Lihat Analytics">
                                            <i class="fas fa-chart-bar"></i>
                                            <span class="btn-text">Analytics</span>
                                        </a>
                                        
                                        <form action="{{ route('admin.ads.toggle', $ad) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn-action btn-toggle {{ $ad->status ? 'active' : 'inactive' }}" 
                                                    data-bs-toggle="tooltip" 
                                                    title="{{ $ad->status ? 'Nonaktifkan Iklan' : 'Aktifkan Iklan' }}">
                                                <i class="fas fa-{{ $ad->status ? 'pause' : 'play' }}"></i>
                                                <span class="btn-text">{{ $ad->status ? 'Nonaktif' : 'Aktif' }}</span>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.ads.destroy', $ad) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirmDelete('{{ $ad->name }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn-action btn-delete" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus Iklan">
                                                <i class="fas fa-trash"></i>
                                                <span class="btn-text">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Modern Pagination -->
                <div class="pagination-modern">
                    <div class="pagination-info">
                        Menampilkan {{ $adSpaces->firstItem() ?? 0 }} - {{ $adSpaces->lastItem() ?? 0 }} dari {{ $adSpaces->total() }} iklan
                    </div>
                    <div>
                        {{ $adSpaces->links() }}
                    </div>
                </div>
            @else
                <!-- Modern Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3 class="empty-title">Belum Ada Iklan</h3>
                    <p class="empty-description">
                        Mulai monetisasi website Anda dengan menambahkan iklan pertama.<br>
                        Pilih dari berbagai jenis iklan yang tersedia untuk memaksimalkan revenue.
                    </p>
                    
                    <div class="feature-grid">
                        <div class="feature-card">
                            <div class="feature-icon primary">
                                <i class="fas fa-image"></i>
                            </div>
                            <h6>Manual Banner</h6>
                            <small class="text-muted">Upload gambar banner sendiri</small>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon success">
                                <i class="fas fa-link"></i>
                            </div>
                            <h6>Text Link</h6>
                            <small class="text-muted">Link teks sederhana</small>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon warning">
                                <i class="fab fa-google"></i>
                            </div>
                            <h6>Google AdSense</h6>
                            <small class="text-muted">Iklan dari Google</small>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon info">
                                <i class="fas fa-code"></i>
                            </div>
                            <h6>Adsera</h6>
                            <small class="text-muted">Platform iklan lokal</small>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.ads.create') }}" class="btn-modern">
                        <i class="fas fa-plus"></i>
                        Buat Iklan Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Modern Professional Ads Management Styles */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
    --card-hover-shadow: 0 20px 40px rgba(0,0,0,0.15);
    --border-radius: 15px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modern-container {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.page-header {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    padding: 2rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
    margin-bottom: 0;
}

.btn-modern {
    background: var(--primary-gradient);
    border: none;
    border-radius: 50px;
    padding: 12px 30px;
    color: white;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: var(--transition);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: var(--border-radius);
    padding: 2rem;
    box-shadow: var(--card-shadow);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--card-hover-shadow);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.stat-card.primary::before { background: var(--primary-gradient); }
.stat-card.success::before { background: var(--success-gradient); }
.stat-card.info::before { background: var(--info-gradient); }
.stat-card.warning::before { background: var(--warning-gradient); }

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-bottom: 1rem;
}

.stat-icon.primary { background: var(--primary-gradient); }
.stat-icon.success { background: var(--success-gradient); }
.stat-icon.info { background: var(--info-gradient); }
.stat-icon.warning { background: var(--warning-gradient); }

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    color: #6c757d;
    font-size: 1rem;
    font-weight: 500;
}

.data-table-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    overflow: hidden;
}

.table-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #dee2e6;
}

.table-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #495057;
    margin-bottom: 0.5rem;
}

.table-subtitle {
    color: #6c757d;
    margin-bottom: 0;
}

.search-container {
    position: relative;
    max-width: 300px;
}

.search-input {
    border: 2px solid #e9ecef;
    border-radius: 50px;
    padding: 10px 20px 10px 45px;
    width: 100%;
    transition: var(--transition);
}

.search-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.modern-table {
    width: 100%;
    margin-bottom: 0;
}

.modern-table th {
    background: #f8f9fa;
    border: none;
    padding: 1rem;
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.modern-table td {
    padding: 1rem;
    border: none;
    border-bottom: 1px solid #f1f3f4;
    vertical-align: middle;
}

.modern-table tbody tr {
    transition: var(--transition);
}

.modern-table tbody tr:hover {
    background: #f8f9fa;
}

.ad-thumbnail {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.ad-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.ad-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.ad-icon.manual_banner { background: var(--primary-gradient); }
.ad-icon.manual_text { background: var(--success-gradient); }
.ad-icon.adsense { background: var(--warning-gradient); }
.ad-icon.adsera { background: var(--info-gradient); }

.ad-info {
    display: flex;
    align-items: center;
}

.ad-details h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
    color: #495057;
}

.ad-details small {
    color: #6c757d;
}

.badge-modern {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
    border: none;
}

.badge-modern.primary { background: var(--primary-gradient); }
.badge-modern.success { background: var(--success-gradient); }
.badge-modern.warning { background: var(--warning-gradient); }
.badge-modern.info { background: var(--info-gradient); }
.badge-modern.danger { background: var(--danger-gradient); }

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
}

.status-badge.active { background: var(--success-gradient); }
.status-badge.inactive { background: var(--warning-gradient); }
.status-badge.expired { background: var(--danger-gradient); }

.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px;
    border-radius: 8px;
    border: none;
    transition: var(--transition);
    color: white;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    min-width: auto;
}

.btn-action:hover {
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
}

.btn-action i {
    font-size: 0.875rem;
}

.btn-text {
    font-size: 0.75rem;
    font-weight: 600;
}

.btn-edit {
    background: var(--primary-gradient);
    box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
}

.btn-edit:hover {
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.btn-analytics {
    background: var(--info-gradient);
    box-shadow: 0 3px 10px rgba(79, 172, 254, 0.3);
}

.btn-analytics:hover {
    box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
}

.btn-toggle {
    box-shadow: 0 3px 10px rgba(17, 153, 142, 0.3);
}

.btn-toggle:hover {
    box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
}

.btn-toggle.active {
    background: var(--warning-gradient);
    box-shadow: 0 3px 10px rgba(240, 147, 251, 0.3);
}

.btn-toggle.inactive {
    background: var(--success-gradient);
    box-shadow: 0 3px 10px rgba(17, 153, 142, 0.3);
}

.btn-delete {
    background: var(--danger-gradient);
    box-shadow: 0 3px 10px rgba(250, 112, 154, 0.3);
}

.btn-delete:hover {
    box-shadow: 0 5px 15px rgba(250, 112, 154, 0.4);
}

.performance-metrics {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.metric-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.875rem;
}

.metric-label {
    color: #6c757d;
}

.metric-value {
    font-weight: 600;
    color: #495057;
}

.ctr-value {
    color: #667eea;
    font-weight: 700;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: var(--primary-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    color: white;
    font-size: 2.5rem;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #495057;
    margin-bottom: 1rem;
}

.empty-description {
    color: #6c757d;
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.feature-card {
    background: white;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    text-align: center;
    box-shadow: var(--card-shadow);
    transition: var(--transition);
}

.feature-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--card-hover-shadow);
}

.feature-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.2rem;
}

.pagination-modern {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: #f8f9fa;
}

.pagination-info {
    color: #6c757d;
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .action-buttons {
        justify-content: center;
        flex-direction: column;
        gap: 5px;
    }
    
    .btn-action {
        justify-content: center;
        width: 100%;
    }
    
    .table-header {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(adName) {
    return confirm(`⚠️ PERINGATAN!\n\nAnda yakin ingin menghapus iklan "${adName}"?\n\nTindakan ini tidak dapat dibatalkan dan akan menghapus:\n• Data iklan\n• Statistik performa\n• Riwayat analytics\n\nKlik OK untuk melanjutkan atau Cancel untuk membatalkan.`);
}

// Modern search functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.modern-table tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endpush