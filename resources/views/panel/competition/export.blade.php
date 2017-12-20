
  <div class="table-responsive table-bordered">
    <table class='table' id="view_sigs_suggestions" border='1'>
      <thead>
        <tr>
          <th>ID</th>
          <th>Entry ID</th>
          <th>Entry Type</th>
          <th>Entry Title</th>
          <th>Email</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($votes as $vote)
      <tr>
        <td>{{ $vote->id }}</td>
        <td>{{ $vote->entry->id }}</td>
        <td>{{ $vote->type }}</td>
        <td>{{ $vote->entry->name }}</td>
        <td>{{ $vote->email }}</td>
        <td>{{ $vote->created_at }}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
