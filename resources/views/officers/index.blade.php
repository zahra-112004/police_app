@extends('components.master')

@section('content')
    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOfficerModal"
                id="addOfficerBtn">
                Add Officer
            </button>
        </div>
    </div>

    <table class="table table-striped" id="officersTable">
        <thead class="bg-primary text-white">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Badge Number</th>
                <th scope="col">Rank</th>
                <th scope="col">Assigned Area</th>
                <th scope="col">Option</th>
            </tr>
        </thead>
        <tbody id="officersTableBody">

        </tbody>
    </table>

    <!-- Modal Create Officer -->
    <div class="modal fade" id="createOfficerModal" tabindex="-1" aria-labelledby="createOfficerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Officer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createOfficerForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="createName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="createName">
                            <small id="createNameError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="createBadgeNumber" class="form-label">Badge Number</label>
                            <input type="text" class="form-control" id="createBadgeNumber">
                            <small id="createBadgeNumberError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="createRank" class="form-label">Rank</label>
                            <input type="text" class="form-control" id="createRank">
                            <small id="createRankError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="createAssignedArea" class="form-label">Assigned Area</label>
                            <input type="text" class="form-control" id="createAssignedArea">
                            <small id="createAssignedAreaError" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="createOfficerForm">Save Officer</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Officer -->
    <div class="modal fade" id="editOfficerModal" tabindex="-1" aria-labelledby="editOfficerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Officer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editOfficerForm">
                    <div class="modal-body">
                        <input type="hidden" id="editOfficerId">

                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName">
                            <small id="editNameError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="editBadgeNumber" class="form-label">Badge Number</label>
                            <input type="text" class="form-control" id="editBadgeNumber">
                            <small id="editBadgeNumberError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="editRank" class="form-label">Rank</label>
                            <input type="text" class="form-control" id="editRank">
                            <small id="editRankError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="editAssignedArea" class="form-label">Assigned Area</label>
                            <input type="text" class="form-control" id="editAssignedArea">
                            <small id="editAssignedAreaError" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Officer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection