@vite(['resources/css/theme.css'])
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@extends('layouts.deduction-settings')

@section('deduction_content')

    <div class="container-fluid px-4 py-5">
{{--               <div class="d-flex justify-content-between align-items-center mb-4">--}}
{{--                   <div>--}}
{{--                       <h1 class="h3 mb-0 text-gray-800 fw-bold">PhilHealth Contribution Settings</h1>--}}
{{--                       <p class="text-muted small mb-0">Manage premium rates, salary floors, and ceilings per effectivity date.</p>--}}
{{--                   </div>--}}
{{--                   <nav aria-label="breadcrumb">--}}
{{--                       <ol class="breadcrumb mb-0">--}}
{{--                           <li class="breadcrumb-item active">PhilHealth</li>--}}
{{--                       </ol>--}}
{{--                   </nav>--}}
{{--               </div>--}}

               @if(session('success'))
                   <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                       <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>
               @endif

               <div class="row g-4">
                   <div class="col-lg-4">
                       <div class="card border-0 shadow-sm overflow-hidden">
                           <div class="card-header bg-white border-bottom py-3">
                               <h5 class="card-title mb-0 fw-bold text-primary">
                                   <i class="bi bi-plus-circle me-2"></i>Add New Schedule
                               </h5>
                           </div>
                           <div class="card-body p-4">
                               <form action="{{ route('philHealth.store') }}" method="POST">
                                   @csrf
                                   <div class="mb-3">
                                       <label class="form-label fw-semibold text-secondary small text-uppercase">Effective Date</label>
                                       <input type="date" name="effectivity_year" class="form-control form-control-lg @error('effectivity_year') is-invalid @enderror" required>
                                       @error('effectivity_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                   </div>

                                   <div class="mb-3">
                                       <label class="form-label fw-semibold text-secondary small text-uppercase">Premium Rate (%)</label>
                                       <div class="input-group">
                                           <input type="number" step="0.01" name="premium_rate" class="form-control form-control-lg" placeholder="5.00" required>
                                           <span class="input-group-text text-muted bg-light border-start-0">%</span>
                                       </div>
                                   </div>

                                   <div class="row g-3 mb-4">
                                       <div class="col-6">
                                           <label class="form-label fw-semibold text-secondary small text-uppercase">Salary Floor</label>
                                           <input type="number" name="salary_floor" value="10000" class="form-control" required>
                                       </div>
                                       <div class="col-6">
                                           <label class="form-label fw-semibold text-secondary small text-uppercase">Salary Ceiling</label>
                                           <input type="number" name="salary_ceiling" value="100000" class="form-control" required>
                                       </div>
                                   </div>

                                   <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm fw-bold">
                                       Save Schedule
                                   </button>
                               </form>
                           </div>
                       </div>
                   </div>

                   <div class="col-lg-8">
                       <div class="card border-0 shadow-sm">
                           <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                               <h5 class="mb-0 text-dark fw-bold">Contribution History</h5>
                           </div>
                           <div class="table-responsive">
                               <table class="table table-hover align-middle mb-0">
                                   <thead class="bg-light text-secondary">
                                   <tr>
                                       <th class="ps-4 py-3 text-uppercase small ls-1 fw-bold" width="25%">Effective Date</th>
                                       <th class="py-3 text-uppercase small ls-1 fw-bold" width="15%">Rate</th>
                                       <th class="py-3 text-uppercase small ls-1 fw-bold text-center" width="30%">Floor — Ceiling</th>
                                       <th class="py-3 text-uppercase small ls-1 fw-bold text-center" width="15%">Status</th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                   @foreach($rates as $rate)
                                       @php
                                           $isActive = ($rate->effectivity_year <= now()->format('Y-m-d')) &&
                                                      ($loop->first || $rates->where('effectivity_year', '>', $rate->effectivity_year)
                                                                           ->where('effectivity_year', '<=', now()->format('Y-m-d'))
                                                                           ->count() == 0);
                                       @endphp
                                       <tr class="{{ $isActive ? 'bg-light bg-opacity-25' : '' }}">
                                           <td class="ps-4">
                                               <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($rate->effectivity_year)->format('M d, Y') }}</div>
                                               <small class="text-muted">Effective Period</small>
                                           </td>
                                           <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 fw-bold" style="font-size: 0.9rem;">
                                                {{ number_format($rate->premium_rate, 2) }}%
                                            </span>
                                           </td>
                                           <td class="text-center">
                                               <span class="text-dark fw-semibold">₱{{ number_format($rate->salary_floor) }}</span>
                                               <span class="text-muted mx-1">—</span>
                                               <span class="text-dark fw-semibold">₱{{ number_format($rate->salary_ceiling) }}</span>
                                           </td>
                                           <td class="text-center">
                                               @if($rate->effectivity_year > now()->format('Y-m-d'))
                                                   <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 py-2">
                                                    Scheduled
                                                </span>
                                               @elseif($rate->status == 'Active')
                                                   <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2">
                                                    Active
                                                </span>
                                               @else
                                                   <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-3 py-2">
                                                    Historical
                                                </span>
                                               @endif
                                           </td>
                                       </tr>
                                   @endforeach
                                   </tbody>
                               </table>
                           </div>
                           <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                               <small class="text-muted">
{{--                                   Showing {{ $rates->firstItem() }} to {{ $rates->lastItem() }} of {{ $rates->total() }} entries--}}
                               </small>
                               <div>
                                   {{ $rates->links('pagination::bootstrap-5') }}
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
@endsection
