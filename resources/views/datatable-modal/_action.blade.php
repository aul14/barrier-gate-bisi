@if (auth()->user()->role == 'admin')
    <a href="javascript:void(0)" data-href="{{ $edit_url }}" data-id="{{ $row_id }}"
        class="btn btn-xs btn-success btn-edit-user" title="Edit"> <i class="fa fa-pencil"></i>
    </a>
    @if ($row_id != auth()->user()->id)
        <form action="{{ $delete_url }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-xs btn-danger" title="Delete"
                onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i>
            </button>
        </form>
    @endif
@endif
<a href="{{ $log_url }}" class="btn btn-xs btn-warning" title="Log User"> <i class="fa fa-user-check"></i>
