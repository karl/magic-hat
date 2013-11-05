group = window.MH?.group

limit = 600

choosing_timeout = null
delay = null
shuffled_people = null
index = null
loop_count = null

choose_name = (results_index) ->
  delay = 10
  loop_count = 0
  shuffled_people = _.shuffle group.lists[results_index]
  index = 0

  results_el = $("#result-#{results_index}")
  $('.no-one', results_el).hide()
  $('.person.displayed', results_el).removeClass('displayed')
  $('.person.choosen', results_el).removeClass('choosen')

  tick results_el, ->
    setTimeout ->
      choose_name results_index + 1 if results_index + 1 < group.lists.length
    , 500

tick = (results_el, callback) ->
  display_person results_el, next_person()

  delay *= 1.1 if loop_count is 1 and delay < 50
  delay *= 1.3 if loop_count >= 2

  if delay > limit
    highlight_choice results_el
    callback()
    return

  clearTimeout choosing_timeout
  choosing_timeout = setTimeout ->
    tick results_el, callback
  , delay

highlight_choice = (results_el) ->
  $('.person.displayed', results_el).addClass('choosen')

next_person = ->
  index += 1
  if index >= shuffled_people.length
    index = 0
    loop_count += 1
    shuffled_people = _.shuffle shuffled_people
  shuffled_people[index]

display_person = (results_el, person) ->
  $('.person.displayed', results_el).removeClass('displayed')
  $(".person-#{person.id}", results_el).addClass('displayed')

$('#chooser').addClass('disabled').attr('disabled': true) if group?.lists.length is 0

$('#chooser').click ->
  $('.displayed').removeClass('displayed')
  $('.no-one').show()
  choose_name(0)





add_list = ->
  index = parseInt($('.lists-container td').length, 10) + 1

  list_el = $("""
    <td>
      <div class="people-field-container">
        <textarea class="people-field" name="list-#{index - 1}" placeholder="Names"></textarea>
      </div>
    </td>
  """)

  $('.lists-container tr').append list_el
  $('.lists-container td').attr 'width', "#{100 / index}%"

remove_list = ->
  $('.lists-container td:last').remove()


$('#add-list').click ->
  add_list()
  return false

$('#remove-list').click ->
  remove_list()
  return false
