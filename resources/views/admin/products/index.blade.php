@extends('admin.app')
@section('title') Sản phẩm @endsection
@section('content')
@section('js')
<script src="{{asset('backend/assets/js/product.js') }}" ></script>
@endsection
<div class="app-title">
    <div>
      <h1>Quản lí sản phẩm</h1>
        <p>Xin chào {{Session::get('emp')->fullName}} </p>
    </div>
    <ul class="app-breadcrumb breadcrumb">

      <li class="breadcrumb-item"><i class="fa fa-home" aria-hidden="true"></i></li>
      <li class="breadcrumb-item"><a href="#">Quản lí sản phẩm</a></li>
    </ul>
</div>
<div class="container">
    <div class="d-flex bd-highlight mb-4">
        <div class="p-2 w-100 bd-highlight">
            <h2>Sản phẩm</h2>
        </div>
        <div class="p-2 flex-shrink-0 bd-highlight">
            <button class="btn btn-success" id="btn-add">
               Thêm mới
            </button>
        </div>
    </div>
    <div>
        <table class="table table-inverse">
            <thead>
                    <tr>
                        <th> Tên sản phẩm</th>
                        <th> Số lượng TK </th>
                        <th> Loại sản phẩm </th>
                        <th> Giá </th>
                        <th> Mô tả </th>
                        <th> Ảnh minh họa</th>
                        <th> Đơn vị tính</th>
                        <th>Trạng thái </th>
                        <th>Thao tác </th>
                        
                    </tr>
            </thead>
            <tbody id="todo-list" name="todo-list">
                @foreach ($data as $item)
                <tr id="todo{{$item->id}}">
                             <td> {{ $item->name }}</td>
                            <td> {{ $item->stock }}</td>
                            <td> {{ $item->type }}</td>
                            <td> {{ number_format( $item->price) }}đ</td>
                            <td> <span>{{ $item->description }}</span></td>

                            <td> <img src="{{$item->image}}"
                                    class="rounded" alt="Ảnh" width="70" height="70"> </td>
                            <td> {{ $item->unit }}</td>
                            <td> {{ $item->status }}</td>
                            <td id="{{$item->id}}">
                                <div class="btn-group">                     
                                    <a class="btn btn-primary" href="#"><i class="fa fa-lg fa-edit"></i></a>
                                    <a class="btn btn-primary" id="btn-delete-product"
                                      ><i class="fa fa-lg fa-trash"></i></a>
                                </div>                              
                            </td>
                @endforeach
            </tbody>
        
        </table>
        <div style="margin:auto">
       
        </div>
        <div class="modal fade" id="formModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="formModalLabel">Tạo sản phẩm</h4>
                    </div>
                    <div class="modal-body">
                        <form id="myForm" name="myForm" class="form-horizontal" >
                            
                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Nhập tên sản phẩm" value="">
                            </div>
                            <div class="form-group">
                                <label>Giá bán</label>
                                <input type="text" class="form-control" id="price" name="price"
                                        placeholder="Nhập giá" value="">
                            </div>
                            <div class="form-group">
                                <label >Chọn loại:</label>
                                <select class="form-select" id="type" name="type">
                                    @foreach($type as $item)
                                    <option>{{$item->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label >Nhập số lượng vào kho:</label>
                                <input type="number" class="form-control" id="stock" placeholder="Nhập stock" name="stock">
                            </div>
                            <div class="form-group">
                                <label>Đơn vị tính:</label>
                                <input type="text" class="form-control" id="unit" placeholder="Nhập đơn vị" name="unit">
                            </div>
                            <div class="form-group">
                                <label>Link ảnh</label>
                                <input type="text" class="form-control" id="image" placeholder="Nhập Link ảnh" name="image" required>
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea class="form-control" rows="3" id="description" name="description"></textarea>
                            </div>
                           
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-add-new" value="add" >Tạo mới
                                </button>
                                <input type="hidden" id="todo_id" name="todo_id" value="0">
                            </div>
                        </form>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
