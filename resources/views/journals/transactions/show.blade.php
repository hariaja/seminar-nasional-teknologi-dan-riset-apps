@extends('layouts.app')
@section('title') {{ trans('page.transactions.title') }} @endsection
@section('hero')
<div class="content content-full">
  <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
    <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">{{ trans('page.transactions.title') }}</h1>
    <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-alt">
        <li class="breadcrumb-item">
          <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-block-option text-danger">
            <i class="fa fa-xs fa-chevron-left me-1"></i>
            {{ trans('page.button.back') }}
          </a>
        </li>
      </ol>
    </nav>
  </div>
</div>
@endsection
@section('content')
<div class="block block-rounded">
  <div class="block-header block-header-default">
    <h3 class="block-title">
      {{ trans('page.transactions.show') }}
    </h3>
  </div>
  <div class="block-content block-content-full">

    <div class="row justify-content-center">
      <div class="col-md-6">

        <ul class="list-group push">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Nama') }}
            <span class="fw-semibold">{{ $transaction->user->name }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Jumlah Pembayaran') }}
            <span class="fw-semibold">{{ Helper::formatRupiah($transaction->amount) }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Tanggal Upload') }}
            <span class="fw-semibold">{{ Helper::customDate($transaction->upload_date) . " | " . $transaction->created_at->format('H:i') }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Status Pembayaran') }}
            <span class="fw-semibold text-uppercase">{{ $transaction->status }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span class="text-center">{{ trans('Statment') }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span class="fw-semibold text-center">{{ $transaction->description }}</span>
          </li>
          @isset($transaction->reason)
            <li class="list-group-item d-flex justify-content-between">
              <span class="text-center">{{ trans('Alasan') }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="fw-semibold text-center">{{ $transaction->reason }}</span>
            </li>
          @endisset
        </ul>

        <h6 class="text-center">{{ trans('Detail Jadwal Yang Dibayarkan') }}</h6>

        <ul class="list-group push">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Agenda') }}
            <span class="fw-semibold">{{ $transaction->registration->title }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Tanggal Mulai') }}
            <span class="fw-semibold">{{ Helper::customDate($transaction->registration->start) }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Tanggal Selesai') }}
            <span class="fw-semibold">{{ Helper::customDate($transaction->registration->end) }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Jenis Kegiatan') }}
            <span class="fw-semibold">{{ $transaction->registration->type }}</span>
          </li>
        </ul>

        @if (me()->hasRole(Constant::ADMIN))
        <form action="{{ route('transactions.update', $transaction->uuid) }}" id="form-update" method="POST" onsubmit="return disableSubmitButton()">
          @csrf
          @method('patch')

          <input type="hidden" name="uuid" id="uuid" value="{{ $transaction->uuid }}">

          @if ($transaction->status === Constant::PENDING)
            <div class="text-center">
              <div class="mb-4">
                <label class="form-label">{{ trans('Pilih Status') }}</label>
                <div class="space-x-2">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="status-pending" name="status" value="{{ Constant::PENDING }}" {{ $transaction->status === Constant::PENDING ? 'checked' : '' }}>
                    <label class="form-check-label text-primary" for="status-pending">{{ Constant::PENDING }}</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="status-approved" name="status" value="{{ Constant::APPROVED }}" {{ $transaction->status === Constant::APPROVED ? 'checked' : '' }}>
                    <label class="form-check-label text-success" for="status-approved">{{ Constant::APPROVED }}</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="status-rejected" name="status" value="{{ Constant::REJECTED }}" {{ $transaction->status === Constant::REJECTED ? 'checked' : '' }}>
                    <label class="form-check-label text-danger" for="status-rejected">{{ Constant::REJECTED }}</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="mb-4" id="reason-area" style="display: none;">
              <label for="reason" class="form-label">{{ trans('Alasan') }} <em>(Jika Ditolak)</em></label>
              <textarea name="reason" id="reason" cols="30" rows="4" class="form-control @error('reason') is-invalid @enderror">{{ old('reason', $transaction->reason) }}</textarea>
              @error('reason')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-4">
              <button type="submit" class="btn btn-primary w-100" id="submit-button">
                <i class="fa fa-fw fa-circle-check opacity-50 me-1"></i>
                {{ trans('page.button.edit') }}
              </button>
            </div>
          @endif

        @endif

      </div>
      <div class="col-md-6">
        <h6 class="text-center">{{ trans('Bukti Pembayaran') }}</h6>
        <div class="animated fadeIn img-link img-link-zoom-in img-thumb img-lightbox">
          <img class="img-fluid img-square-center" src="{{ Storage::url($transaction->proof) }}" alt="">
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
@push('javascript')
  <script>

    $(function () {

      $('input[name="status"]').change(function() {
        if ($(this).val() === 'Rejected') {
          $('#reason-area').show()
        } else {
          $('#reason-area').hide()
          $('#reason').val('')
        }
      })

    })

  </script>
@endpush