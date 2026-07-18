document.addEventListener("DOMContentLoaded", function () {

    const addBtn = document.getElementById("addSubjectBtn");
    const container = document.getElementById("subjectContainer");

    if (!addBtn || !container) return;

    addBtn.addEventListener("click", function () {

        const card = document.createElement("div");
        card.className = "subject-card";

        card.innerHTML = `

        <hr style="margin:25px 0; opacity:.3;">

        <div class="grid">

            <div class="input-group">
                <label>Subject Code</label>
                <input
                    type="text"
                    name="subject_code[]"
                    required
                >
            </div>

            <div class="input-group">
                <label>Subject Name</label>
                <input
                    type="text"
                    name="subject_name[]"
                    required
                >
            </div>

            <div class="input-group">
                <label>Course</label>
                <select
                    name="course[]"
                    required
                >
                    <option value="">Select Course</option>
                    <option>BSIT</option>
                    <option>BSBA</option>
                    <option>BSHM</option>
                    <option>BSTM</option>
                    <option>BEED</option>
                    <option>BSED</option>
                </select>
            </div>

            <div class="input-group">
                <label>Year Level</label>
                <select
                    name="year_level[]"
                    required
                >
                    <option value="">Select Year</option>
                    <option>1st Year</option>
                    <option>2nd Year</option>
                    <option>3rd Year</option>
                    <option>4th Year</option>
                </select>
            </div>

            <div class="input-group">
                <label>Section</label>
                <input
                    type="text"
                    name="section[]"
                    required
                >
            </div>

            <div class="input-group">
                <label>Day</label>
                <select
                    name="day[]"
                    required
                >
                    <option>Monday</option>
                    <option>Tuesday</option>
                    <option>Wednesday</option>
                    <option>Thursday</option>
                    <option>Friday</option>
                    <option>Saturday</option>
                </select>
            </div>

            <div class="input-group">
                <label>Start Time</label>
                <input
                    type="time"
                    name="start_time[]"
                    required
                >
            </div>

            <div class="input-group">
                <label>End Time</label>
                <input
                    type="time"
                    name="end_time[]"
                    required
                >
            </div>

            <div class="input-group">
                <label>Spreadsheet Class</label>
                <select
                    name="spreadsheet_class[]"
                    required
                >
                    <option>IT1</option>
                    <option>IT2</option>
                    <option>IT3</option>
                    <option>IT4</option>
                </select>
            </div>

            <div class="input-group" style="display:flex;align-items:end;">

                <button
                    type="button"
                    class="removeSubject"
                    style="
                        width:100%;
                        background:#d32f2f;
                        margin-top:30px;
                    "
                >
                    <i class="fa-solid fa-trash"></i>
                    Remove Subject
                </button>

            </div>

        </div>

        `;

        container.appendChild(card);

    });

    container.addEventListener("click", function (e) {

        if (e.target.classList.contains("removeSubject") ||
            e.target.closest(".removeSubject")) {

            const cards = container.querySelectorAll(".subject-card");

            if (cards.length > 1) {

                e.target.closest(".subject-card").remove();

            } else {

                alert("At least one subject is required.");

            }

        }

    });

});