<?php
include 'header.php';
?>



    <div class="container col-md-6 center-screen">
        <div class="card">
            <div class="card-header">
                Featured
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="universtyName">Enter The Cave Name</label>
                        <input type="text" class="form-control" id="company_name" placeholder="Havana Propartice">
                    </div>
                    <div class="form-group">
                        <label for="universtyName">Enter The Cave Description</label>
                        <textarea placeholder="Enter description" id="company-content" name="description" rows="2" spellcheck="false" class="form-control autosize-target text-left"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="universtyName">Enter The Type of Cave</label>
                        <select class="form-control">
                            <option selected hidden>Select one...</option>
                            <option>Data House</option>
                            <option>Grosarry</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

<?php
include 'footer.php';
?>