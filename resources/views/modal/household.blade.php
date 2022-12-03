<div class="modal modal-lg fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="residentForm" id="residentForm" enctype="multipart/form-data">
            <div id="printThis">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"> <i class="bi-info-circle"></i></h5>
                    <button type="button" class="btn-close household-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                        {{-- hidden id --}}
                        <input type="hidden" name="id" id="id">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th style="width: 220px;">Name</th>
                                    <th style="width: 60px;">Age</th>
                                    <th style="width: 100px;">Gender</th>
                                    <th style="width: 150;">Civil Status</th>
                                    <th style="width: 150px;">Mobile Number</th>
                                </tr>
                            </thead>
                            <tbody id="result"></tbody>
                        </table>
                  </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" name="print" id="print" >Print</button>
            </div>
        </form>
      </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#print').click(function(){
            $('body').addClass('bodys');
            $('bodys').css('visibility', 'hidden');
        })

        document.getElementById("print").onclick = function () {
            printElement(document.getElementById("printThis"));
        };
        function printElement(elem) {
            var domClone = elem.cloneNode(true);

            var $printSection = document.getElementById("printSection");

            if (!$printSection) {
                var $printSection = document.createElement("div");
                $printSection.id = "printSection";
                document.body.appendChild($printSection);
            }

            $printSection.innerHTML = "";
            $printSection.appendChild(domClone);
            window.print();
        }
    });
</script>