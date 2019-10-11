<div class="modal fade" id="deletepromotionmodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalpromotionlabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletemodalpromotionlabel">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <p class="font-12">{{__('Are you sure you want to delete Item?')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('No')}}</button>
                <button type="button" class="btn btn-danger" id="btnDeletePromotion">{{__('Yes')}}</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="croppermodal" tabindex="-1" role="dialog" aria-labelledby="cropmodallabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropmodallabel">Image Cropper</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="upload-demo-wrap" style="display: none">
                    <div id="upload-demo"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
                <button type="button" class="btn upload-result">{{__('Upload')}}</button>
            </div>
        </div>
    </div>
</div>

