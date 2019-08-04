<!-- Delete Modal -->
<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" id="deleteForm" method="post">
        <div class="modal-header bg-danger">
          <h5 class="modal-title" id="exampleModalLabel">{{ __("DELETE CONFIRMATION") }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <p class="text-center">{{ __("Are you sure want to delete this data?") }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Cancel") }}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="formSubmit()">{{ __("Yes, Delete") }}</button>
        </div>
      </form>
    </div>
  </div>
</div>
