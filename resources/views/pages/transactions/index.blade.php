@extends('layouts.app')

@section('title', 'Transactions')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Transactions</h1>
                <div class="section-header-button">
                    <a href="{{ route('transaction.create') }}" class="btn btn-primary">Tambah Penjualan</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Cashier</a></div>
                    <div class="breadcrumb-item">Transaksi</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Transactions</h2>
                <p class="section-lead">
                    You can manage all Transactions
                </p>

                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('transaction.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <th>#</th>
                                        <th>staff</th>
                                        <th>Tanggal Penjualan</th>
                                        <th>Total Harga</th>
                                        <th>Action</th>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $transaction->user->name }}
                                                </td>
                                                <td>
                                                    {{ $transaction->created_at }}
                                                </td>
                                                <td>
                                                    Rp. {{ format_rupiah($transaction->total_harga) }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-start">
                                                        <a href="{{ route('detail.show', $transaction->id) }}"
                                                            class="btn btn-action btn-warning mr-3" data-toggle="tooltip"
                                                            title="View"> <i class="fas fa-magnifying-glass"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $transactions->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
