@extends('layout.template')

@section('content')

<section class="section">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <img src="/storage/img/teachers/teacher.png" width="100" class="rounded" alt="">
                    </div>
                    <div class="col-8">
                        <div class="card-text">
                            <p>
                                <strong class="fs-5">Mukhlis Amrullah</strong>
                            </p>
                            <p>
                                <strong>Jabatan</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-group list-group-horizontal text-center" role="tablist">
                <a class="list-group-item list-group-item-action rounded-0 active" id="list-sunday-list"
                    data-bs-toggle="list" href="#list-sunday" role="tab" aria-selected="false">Detail</a>
                <a class="list-group-item list-group-item-action" id="list-monday-list" data-bs-toggle="list"
                    href="#list-monday" role="tab" aria-selected="false">Kehadiran</a>
                <a class="list-group-item list-group-item-action rounded-0" id="list-tuesday-list" data-bs-toggle="list"
                    href="#list-tuesday" role="tab" aria-selected="true">Edit</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="tab-content text-justify">
                    <div class="tab-pane fade active show" id="list-sunday" role="tabpanel"
                        aria-labelledby="list-sunday-list">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <span>Nama</span>
                            </div>
                            <div class="col-md-8">
                                <strong>Mukhlis Amrullah</strong>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <span>Jabatan</span>
                            </div>
                            <div class="col-md-8">
                                <strong>Guru kelas 7, 8</strong>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <span>Mata Pelajaran</span>
                            </div>
                            <div class="col-md-8">
                                <strong>Bahasa Indonesia, Matematika</strong>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-monday" role="tabpanel" aria-labelledby="list-monday-list">
                        Cupidatat
                        quis ad sint excepteur laborum in esse qui. Et excepteur consectetur ex nisi eu do
                        cillum ad laborum.
                        Mollit et eu officia dolore sunt Lorem culpa qui commodo velit ex amet id ex. Officia
                        anim incididunt
                        laboris deserunt anim aute dolor incididunt veniam aute dolore do exercitation. Dolor
                        nisi culpa ex ad
                        irure in elit eu dolore. Ad laboris ipsum reprehenderit irure non commodo enim culpa
                        commodo veniam
                        incididunt veniam ad. Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                        Exercitationem, porro!
                        Amet soluta tempora eveniet blanditiis alias eos, dolor qui consectetur!
                    </div>
                    <div class="tab-pane fade" id="list-tuesday" role="tabpanel" aria-labelledby="list-tuesday-list">Ut
                        ut
                        do pariatur aliquip aliqua aliquip exercitation do nostrud commodo reprehenderit aute
                        ipsum voluptate.
                        Irure Lorem et laboris nostrud amet cupidatat cupidatat anim do ut velit mollit
                        consequat enim tempor.
                        Consectetur est minim nostrud nostrud consectetur irure labore voluptate irure. Ipsum id
                        Lorem sit
                        sint voluptate est pariatur eu ad cupidatat et deserunt culpa sit eiusmod deserunt.
                        Consectetur et
                        fugiat anim do eiusmod aliquip nulla laborum elit adipisicing pariatur cillum. Lorem
                        ipsum dolor sit
                        amet consectetur adipisicing elit. Molestias, inventore!
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection