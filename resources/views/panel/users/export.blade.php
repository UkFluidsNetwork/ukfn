
  <div class="table-responsive table-bordered">
    <table class='table' id="view_sigs_suggestions" border='1'>
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Name</th>
          <th>Surname</th>
          <th>Email</th>
          <th>ORCID ID</th>
          <th>Website</th>
          <th>Institutions</th>
          <th>Sub-disciplines</th>
          <th>Application areas</th>
          <th>Techniques</th>
          <th>Facilities</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td>{{ isset($user->title) ? $user->title['shortname'] : '' }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->surname }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->orcidid }}</td>
        <td>{{ $user->url }}</td>
        <td>
            @foreach ($user->institutions as $institution)
                {{ $institution['name'] }}, 
            @endforeach
        </td>
        <td>
            @if (!empty($user->tags))
                @foreach ($user->tags as $key => $tag)
                    @if ($tag->tagtype->name === 'Sub-disciplines')
                        {{ $tag->name }}, 
                    @endif
                @endforeach
            @endif            
        </td>
        <td>
            @if (!empty($user->tags))
                @foreach ($user->tags as $tag)
                    @if ($tag->tagtype->name === 'Application Area')
                        {{ $tag->name }}, 
                    @endif
                @endforeach
            @endif            
        </td>
        <td>
            @if (!empty($user->tags))
                @foreach ($user->tags as $tag)
                    @if ($tag->tagtype->name === 'Techniques')
                        {{ $tag->name }}, 
                    @endif
                @endforeach
            @endif            
        </td>
        <td>
            @if (!empty($user->tags))
                @foreach ($user->tags as $tag)
                    @if ($tag->tagtype->name === 'Facilities')
                        {{ $tag->name }}, 
                    @endif
                @endforeach
            @endif            
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
