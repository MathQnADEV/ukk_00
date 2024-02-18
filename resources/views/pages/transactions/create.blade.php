@extends('layouts.app')

@section('title', 'Table')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Table</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Table</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Table</h2>
                <p class="section-lead">Example of some Bootstrap table components.</p>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" class="form-group">
                                    <label>Nama Produk</label>
                                    <div class="d-flex">
                                        <select class="form-control select2" name="produk_id">
                                            <option>Pilih ges</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->id . ' - ' . $product->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm ml-4">Pilih</button>
                                    </div>
                                </form>
                                <form action="{{ route('detail.store') }}" method="POST">
                                    @csrf

                                    <input type="hidden" name="transaction_id" value="{{ Request::segment(2) }}">
                                    <input type="hidden" name="product_id"
                                        value="{{ isset($p_detail) ? $p_detail->id : '' }}">
                                    <input type="hidden" name="product_name"
                                        value="{{ isset($p_detail) ? $p_detail->name : '' }}">
                                    <input type="hidden" name="subtotal" value="{{ isset($subtotal) ? $subtotal : '' }}">


                                    <div class="form-group">
                                        <label>Nama Produk</label>
                                        <input type="text" class="form-control"
                                            value="{{ isset($p_detail) ? $p_detail->name : '' }}" disabled
                                            name="nama_produk">
                                    </div>
                                    <div class="form-group">
                                        <label>Harga Satuan</label>
                                        <input type="text" class="form-control"
                                            value="{{ isset($p_detail) ? format_rupiah($p_detail->price) : '' }}" disabled
                                            name="price">
                                    </div>
                                    <div class="form-group">
                                        <label>QTY</label>
                                        <div class="d-flex items-center">
                                            <a href="?produk_id={{ request('produk_id') }}&act=min&qty={{ isset($qty) ? $qty : '' }}"
                                                class="btn btn-primary btn-md mr-3">
                                                <i class="fas fa-minus"></i>
                                            </a>
                                            <input type="number" class="form-control"
                                                value="{{ isset($qty) ? $qty : '' }}" name="qty" id="qty">
                                            <a href="?produk_id={{ request('produk_id') }}&act=plus&qty={{ isset($qty) ? $qty : '' }}"
                                                class="btn btn-primary btn-md ml-3">
                                                <i class="fas fa-plus"></i>
                                            </a>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h3>Subtotal : Rp.
                                            {{ isset($subtotal) ? format_rupiah($subtotal) : '0' }}
                                        </h3>
                                    </div>
                                    <div class="form-group d-flex justify-content-end">
                                        <button class="btn btn-success" type="submit">
                                            Kembali
                                        </button>
                                        <button class="btn btn-primary ml-3" type="submit">
                                            Tambah
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-bordered table-md table">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>QTY</th>
                                            <th>Sub Total</th>
                                            <th>Action</th>
                                        </tr>
                                        @isset($transaction_detail)
                                            @foreach ($transaction_detail as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->product_name }}</td>
                                                    <td>{{ $item->qty }} </td>
                                                    <td>
                                                        Rp. {{ format_rupiah($item->subtotal) }}
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-danger btn-action" data-toggle="tooltip"
                                                            title="Delete"
                                                            data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                            data-confirm-yes="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit()"><i
                                                                class="fas fa-trash"></i>
                                                        </a>

                                                        <form action="{{ route('detail.destroy', $item->id) }}" method="POST"
                                                            id="delete-form-{{ $item->id }}" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset

                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                {{ isset($transaction_detail) ? $transaction_detail->withQueryString()->links() : '' }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="" method="GET">
                            <input type="hidden" name="total_harga">

                            <div class="form-group">
                                <h3>Total Belanja : Rp.
                                    {{ format_rupiah($transaction->total_harga) }}
                                </h3>
                            </div>
                            <div class="form-group">
                                <label>Dibayarkan</label>
                                <input type="numeric" class="form-control" value="{{ request('dibayarkan') }}"
                                    name="dibayarkan">
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button class="btn btn-success" type="submit">
                                    Hitung Kembalian
                                </button>
                            </div>
                        </form>
                        <div class="form-group">
                            <h3>Kembalian : Rp.
                                {{ format_rupiah($kembalian) }}
                            </h3>
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('transaction.index') }}" class="btn btn-success">
                                Selesai
                            </a>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Advanced Table</h4>
                                <div class="card-header-form">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>Task Name</th>
                                            <th>Progress</th>
                                            <th>Members</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        class="custom-control-input" id="checkbox-1">
                                                    <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>Create a mobile app</td>
                                            <td class="align-middle">
                                                <div class="progress" data-height="4" data-toggle="tooltip"
                                                    title="100%">
                                                    <div class="progress-bar bg-success" data-width="100"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <img alt="image" src="{{ asset('img/avatar/avatar-5.png') }}"
                                                    class="rounded-circle" width="35" data-toggle="tooltip"
                                                    title="Wildan Ahdian">
                                            </td>
                                            <td>2018-01-20</td>
                                            <td>
                                                <div class="badge badge-success">Completed</div>
                                            </td>
                                            <td><a href="#" class="btn btn-secondary">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        class="custom-control-input" id="checkbox-2">
                                                    <label for="checkbox-2" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>Redesign homepage</td>
                                            <td class="align-middle">
                                                <div class="progress" data-height="4" data-toggle="tooltip"
                                                    title="0%">
                                                    <div class="progress-bar" data-width="0"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}"
                                                    class="rounded-circle" width="35" data-toggle="tooltip"
                                                    title="Nur Alpiana">
                                                <img alt="image" src="{{ asset('img/avatar/avatar-3.png') }}"
                                                    class="rounded-circle" width="35" data-toggle="tooltip"
                                                    title="Hariono Yusup">
                                                <img alt="image" src="{{ asset('img/avatar/avatar-4.png') }}"
                                                    class="rounded-circle" width="35" data-toggle="tooltip"
                                                    title="Bagus Dwi Cahya">
                                            </td>
                                            <td>2018-04-10</td>
                                            <td>
                                                <div class="badge badge-info">Todo</div>
                                            </td>
                                            <td><a href="#" class="btn btn-secondary">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        class="custom-control-input" id="checkbox-3">
                                                    <label for="checkbox-3" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>Backup database</td>
                                            <td class="align-middle">
                                                <div class="progress" data-height="4" data-toggle="tooltip"
                                                    title="70%">
                                                    <div class="progress-bar bg-warning" data-width="70"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}"
                                                    class="rounded-circle" width="35" data-toggle="tooltip"
                                                    title="Rizal Fakhri">
                                                <img alt="image" src="{{ asset('img/avatar/avatar-2.png') }}"
                                                    class="rounded-circle" width="35" data-toggle="tooltip"
                                                    title="Hasan Basri">
                                            </td>
                                            <td>2018-01-29</td>
                                            <td>
                                                <div class="badge badge-warning">In Progress</div>
                                            </td>
                                            <td><a href="#" class="btn btn-secondary">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        class="custom-control-input" id="checkbox-4">
                                                    <label for="checkbox-4" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>Input data</td>
                                            <td class="align-middle">
                                                <div class="progress" data-height="4" data-toggle="tooltip"
                                                    title="100%">
                                                    <div class="progress-bar bg-success" data-width="100"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <img alt="image" src="{{ asset('img/avatar/avatar-2.png') }}"
                                                    class="rounded-circle" width="35" data-toggle="tooltip"
                                                    title="Rizal Fakhri">
                                                <img alt="image" src="{{ asset('img/avatar/avatar-5.png') }}"
                                                    class="rounded-circle" width="35" data-toggle="tooltip"
                                                    title="Isnap Kiswandi">
                                                <img alt="image" src="{{ asset('img/avatar/avatar-4.png') }}"
                                                    class="rounded-circle" width="35" data-toggle="tooltip"
                                                    title="Yudi Nawawi">
                                                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}"
                                                    class="rounded-circle" width="35" data-toggle="tooltip"
                                                    title="Khaerul Anwar">
                                            </td>
                                            <td>2018-01-16</td>
                                            <td>
                                                <div class="badge badge-success">Completed</div>
                                            </td>
                                            <td><a href="#" class="btn btn-secondary">Detail</a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/components-table.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
@endpush
