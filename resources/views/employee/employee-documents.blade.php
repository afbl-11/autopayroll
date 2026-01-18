<x-app :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
    <section class="main-content">
        <div class="content-wrapper" style="padding: 2rem;">
            <h2 style="margin-bottom: 1.5rem;">Employee Documents</h2>
            
            @if(!empty($employee->uploaded_documents))
                @php
                    $documents = is_string($employee->uploaded_documents) 
                        ? json_decode($employee->uploaded_documents, true) 
                        : $employee->uploaded_documents;
                @endphp
                
                @if(is_array($documents) && count($documents) > 0)
                    <div class="documents-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
                        @foreach($documents as $index => $document)
                            @php
                                $extension = pathinfo($document, PATHINFO_EXTENSION);
                                $fileName = basename($document);
                            @endphp
                            <div class="document-card" style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1rem; background: white;">
                                <div class="document-preview" style="text-align: center; margin-bottom: 1rem;">
                                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                        <img src="{{ asset('storage/' . $document) }}" 
                                             alt="Document {{ $index + 1 }}" 
                                             style="max-width: 100%; height: 200px; object-fit: cover; border-radius: 4px; cursor: pointer;"
                                             onclick="window.open('{{ asset('storage/' . $document) }}', '_blank')">
                                    @elseif(strtolower($extension) === 'pdf')
                                        <div style="height: 200px; display: flex; align-items: center; justify-content: center; background: #f3f4f6; border-radius: 4px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#ef4444" viewBox="0 0 16 16">
                                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                                <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="document-info">
                                    <p style="font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem; word-break: break-word;">{{ $fileName }}</p>
                                    <p style="font-size: 0.75rem; color: #6b7280; text-transform: uppercase; margin-bottom: 1rem;">{{ $extension }} File</p>
                                    <a href="{{ asset('storage/' . $document) }}" 
                                       target="_blank" 
                                       class="btn-primary" 
                                       style="display: inline-block; padding: 0.5rem 1rem; background: #3b82f6; color: white; text-decoration: none; border-radius: 4px; font-size: 0.875rem; text-align: center; width: 100%;">
                                        View Document
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 3rem; color: #6b7280;">
                        <p>No documents uploaded yet.</p>
                    </div>
                @endif
            @else
                <div style="text-align: center; padding: 3rem; color: #6b7280;">
                    <p>No documents uploaded yet.</p>
                </div>
            @endif
        </div>
    </section>
</x-app>
