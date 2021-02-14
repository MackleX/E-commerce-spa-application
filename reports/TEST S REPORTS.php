<div class="table-responsive">
                        <table class="table">
                            <thead class=" text-primary">
                                <th>
                                    name
                                </th>
                                <th style="width: 10%;">
                                    qty
                                </th>
                                <th style="width: 10%;">
                                    price
                                </th>

                                <th class="text-center">
                                    options
                                </th>
                            </thead>

                            <tbody>

                                <tr>
                                    <td>
                                        <input type="text" form="myform" style="width:100%; vertical-align: top;" value="prodName"/>
                                    </td>


                                    <td>

                                        <input type="number" form="myform" style="width:100%; vertical-align: top;" value="prodqty" />

                                    </td>
                                    <td>
                                        <input type="number" form="myform" style="width:100%; vertical-align: top;" value="prodPrice"/>
                                    </td>

                                    <td>


                                    //each option
                                        <table class="table op_1">

                                            <thead>
                                                <tr class="text-center">
                                                    <th class="text-center" style="width:100%">
                                                        option_name
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>


                                                //each value
                                                <tr>

                                                    <td class="text-center op_id val_id">
                                                        value_name: addedPrice
                                                        <button class="btn btn-primary btn-fab btn-fab-mini btn-round deleteValueButton">
                                                            <i class="material-icons">plus</i>
                                                        </button>
                                                    </td>


                                                </tr>


                                                <tr>
                                                    <td>


                                                        <form id="op_1" onsubmit="return addValue(this)">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <input name="valName" type="text" class="form-control" placeholder="Option name" required>
                                                                </div>
                                                                <div class="col">
                                                                    <input name="valPrice" type="number" class="form-control" placeholder="Option Added price" required>
                                                                </div>

                                                            </div>
                                                            <input type="submit" name="" id="">
                                                            <div class="text-center">
                                                                <button type="submit" class="btn btn-primary btn-fab btn-fab-mini btn-round">
                                                                    <i class="material-icons">plus</i>
                                                                </button>
                                                            </div>
                                                        </form>




                                                    </td>

                                            </tbody>

                                        </table>





                                        
                                        <table class="table op_2">

                                            <thead>
                                                <tr class="text-center">
                                                    <th class="text-center" style="width:100%">
                                                        option 1
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <tr>

                                                    <td class="text-center op_id val_id">
                                                        p_value1: value1
                                                        <button class="btn btn-primary btn-fab btn-fab-mini btn-round deleteValueButton">
                                                            <i class="material-icons">plus</i>
                                                        </button>
                                                    </td>


                                                </tr>


                                                <tr>

                                                    <td class="text-center">
                                                        p_value1 : value
                                                        <button class="btn btn-primary btn-fab btn-fab-mini btn-round deleteValueButton">
                                                            <i class="material-icons">plus</i>
                                                        </button>
                                                    </td>

                                                </tr>




                                                <tr>
                                                    <td>


                                                        <form id="op_2" onsubmit="return addValue(this)">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <input name="valName" type="text" class="form-control" placeholder="Option name" required>
                                                                </div>
                                                                <div class="col">
                                                                    <input name="valPrice" type="number" class="form-control" placeholder="Option Added price" required>
                                                                </div>

                                                            </div>
                                                            <input type="submit" name="" id="">
                                                            <div class="text-center">
                                                                <button type="submit" class="btn btn-primary btn-fab btn-fab-mini btn-round">
                                                                    <i class="material-icons">plus</i>
                                                                </button>
                                                            </div>
                                                        </form>




                                                    </td>

                                            </tbody>

                                        </table>


                                    </td>


                                </tr>




                                </td>

                                </tr>

                            </tbody>
                        </table>

                    </div>