<?php
$notes = \App\Models\Note::whereRaw('1=1')->get();
?>

@if(!empty($notes) && count($notes) > 0)
    @foreach($notes as $note)
        <div class="d-flex align-items-center justify-content-between py-8">
            <div class="d-flex flex-column mr-2">
                <span class="font-weight-bold text-dark-75 font-size-lg">
                    {{ $note->title ?? '' }}
                </span>
                <span class="text-muted">
                    {{ $note->description ?? '' }}
                </span>
                <span class="text-muted">
                    {{ \Carbon\Carbon::parse($note->created_at)->diffForHumans() }}
                </span>
            </div>

            <div class="btn-group" role="group" aria-label="Notes Action Buttons">
                @if($is_root_user == 1 || in_array('notes.edit', $accesses_urls))
                    <button type="button" class="btn btn-sm btn-outline-primary edit_note"
                            data-note-id="{{ $note->id }}"
                            data-title="{{ $note->title }}"
                            data-description="{{ $note->description }}">
                        <i class="fa fa-pencil-alt"></i>
                    </button>
                @endif

                @if($is_root_user == 1 || in_array('notes.delete', $accesses_urls))
                    <button type="button" class="btn btn-sm btn-outline-danger delete_note"
                            data-note-id="{{ $note->id }}">
                        <i class="fa fa-times"></i>
                    </button>
                @endif
            </div>
        </div>
        <div class="separator separator-solid"></div>
    @endforeach
@else
    <p class="text-muted font-size-h6">No notes found.</p>
@endif
