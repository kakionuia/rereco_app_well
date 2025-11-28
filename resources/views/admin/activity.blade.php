@extends('admin.layout')

@section('title','Activity Log')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Activity Log</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Admin</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Data</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($activities as $act)
                        @php
                            $subjectName = $act->subject_type ? class_basename($act->subject_type) . ' #' . $act->subject_id : null;
                            $detailLink = null;
                            if ($act->subject_type && class_basename($act->subject_type) === 'SampahSubmission') {
                                // link to admin submission detail
                                $detailLink = route('admin.sampah.show', $act->subject_id);
                            }
                        @endphp
                        <tr @if($detailLink) onclick="location.href='{{ $detailLink }}'" class="cursor-pointer hover:bg-gray-50 transition" @endif>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $act->created_at->format('j M Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $act->user?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-700">{{ $act->action }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($detailLink)
                                    <a href="{{ $detailLink }}" class="text-blue-600 hover:text-blue-800">{{ $subjectName }}</a>
                                @else
                                    {{ $subjectName ?? '-' }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">@if($act->data){{ json_encode($act->data) }}@endif</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if($detailLink)
                                    <a href="{{ $detailLink }}" class="text-gray-500 hover:text-gray-700 transition" title="Buka detail">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $activities->links() }}</div>
    </div>
@endsection
