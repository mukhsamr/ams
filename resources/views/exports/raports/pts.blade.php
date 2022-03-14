<div class="center" style="font-size: 14px"><strong>STUDENT MIDDLE TEST REPORT</strong></div>
<div class="flex margin">
    <div class="item" style="width: 50%">
        <div class="flex">
            <div class="item" style="width: 30%">
                <div>School Name</div>
                <div>Student Name</div>
                <div>Number</div>
            </div>
            <div class="item" style="width: 70%">
                <div>: {{ $school->name }}</div>
                <div>: {!! $student->nama !!}</div>
                <div>: {{ $student->nipd . ' - ' . $student->nisn }}</div>
            </div>
        </div>
    </div>
    <div class="item" style="width: 50%">
        <div class="flex">
            <div class="item" style="width: 50%">
                <div>Class</div>
                <div>Semester</div>
                <div>Academic Year</div>
            </div>
            <div class="item" style="width: 50%">
                <div>: {{ $subGrade->sub_grade . ' ' . $subGrade->name }}</div>
                <div>: {{ $version->semester }}<sup>{{ ordinal($version->semester) }}</sup></div>
                <div>: {{ $version->school_year }}</div>
            </div>
        </div>
    </div>
</div>

<table width="100%" class="margin">
    <thead>
        <tr>
            <th rowspan="2" id="no">No</th>
            <th rowspan="2">Subjects</th>
            @foreach($columns as $column)
            <th colspan="2">BC {{ $column }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach($columns as $column)
            <th>C</th>
            <th>S</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($raports as $subject => $values)
        <tr>
            <th>{{ $loop->iteration }}</th>
            <td>{{ $subject }}</td>
            @forelse ($values as $key => $value)

            @if ($loop->iteration > count($columns)) @break @endif

            <td class="center">{{ $value["3_$key"] ?? '-' }}</td>
            <td class="center">{{ $value["4_$key"] ?? '-' }}</td>

            @if ($loop->last && $loop->iteration < count($columns)) @for ($i=0; $i < (count($columns) - $loop->
                iteration); $i++)
                <td class="center">-</td>
                <td class="center">-</td>
                @endfor
                @endif

                @empty
                @foreach ($columns as $column)
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                @endforeach
                @endforelse
        </tr>
        @endforeach
    </tbody>
</table>

<div class="margin">
    <div>BC : Basic Competence</div>
    <div>C : Cognitive</div>
    <div>S : Skills</div>
</div>

<div class="margin2 right">{{ $setting->place }}</div>
<div class="margin">Acknowledged by</div>
<div class="margin flex">
    <div class="item" style="width: 50%">Headmistress</div>
    <div class="item right" style="width: 50%">Homebase Teacher</div>
</div>
<div class="margin flex">
    <div class="item" style="width: 50%; height: 90px;">
        @if ($setting->background)
        <img src="{{ $school->signature }}" alt="signature" style="width: auto; height: 90px;">
        @endif
    </div>
    <div class="item right" style="width: 50%; height: 90px;">
        @if ($setting->background)
        <img src="{{ asset('storage/img/guardians/' . $guardian->signature) }}" alt="signature"
            style="width: auto; height: 90px;">
        @endif
    </div>
</div>
<div class="margin flex">
    <div class="item" style="width: 50%"><strong>{!! $school->teacher->nama !!}</strong></div>
    <div class="item right" style="width: 50%"><strong>{!! $guardian->nama !!}</strong></div>
</div>

@if ($setting->background)
<style>
    @page {
        background-image: url('{{ $school->logo }}');
        background-image-resize: 4;
        background-repeat: no-repeat;
        background-size: contain;
        background-position: center;
        background-image-opacity: 0.15;
    }
</style>
@endif
<style>
    body,
    html {
        font-size: 12px;
    }

    table,
    th,
    td {
        padding: 3px;
        border: 1.5px solid black;
        border-collapse: collapse;
    }

    #no {
        width: 30px;
        text-align: center
    }

    .center {
        text-align: center;
    }

    .flex {
        display: flex;
    }

    .item {
        float: left;
    }

    .margin {
        margin-top: 12px;
    }

    .margin2 {
        margin-top: 24px;
    }

    .right {
        text-align: right;
    }
</style>