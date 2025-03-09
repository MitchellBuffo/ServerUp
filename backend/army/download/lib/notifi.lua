local imgui = require 'mimgui'
local encoding = require 'encoding'
encoding.default = 'CP1251'
u8 = encoding.UTF8

local FontsText = {}
imgui.OnInitialize(function()
    imgui.GetIO().IniFilename = nil
   
    local SizeText = { 20, 25 }
    for i = 1, #SizeText do
        if FontsText[tonumber(SizeText[i])] == nil then
            FontsText[tonumber(SizeText[i])] = imgui.GetIO().Fonts:AddFontFromFileTTF(
                getGameDirectory() .. '/moonloader/ArmyScript/fonts/proximanova_bold.otf', tonumber(SizeText[i]), nil, imgui.GetIO().Fonts:GetGlyphRangesCyrillic()
            )
        end
    end
end)


local list = {}
EXPORTS = {
    __version = '0.1',
    Show = function(text, type, time)
        table.insert(list, {
            text = text,
            type = type or 2,
            time = time or 4,
            start = os.clock(),
            alpha = 0
        })
    end
}

local newFrame = imgui.OnFrame(
    function() return #list > 0 end,
    function(self)
        self.HideCursor = true
        local resX, resY = getScreenResolution()
        local sizeX, sizeY = 300, 300
        imgui.SetNextWindowPos(imgui.ImVec2(resX / 2, resY / 2), imgui.Cond.FirstUseEver, imgui.ImVec2(0.5, 0.5))
        imgui.SetNextWindowSize(imgui.ImVec2(sizeX, sizeY), imgui.Cond.FirstUseEver)
        imgui.Begin('notf_window', _, 0
            + imgui.WindowFlags.AlwaysAutoResize
            + imgui.WindowFlags.NoTitleBar
            + imgui.WindowFlags.NoResize
            + imgui.WindowFlags.NoMove
            + imgui.WindowFlags.NoBackground
        )
        
        local winSize = imgui.GetWindowSize()
        imgui.SetWindowPosVec2(imgui.ImVec2(resX - winSize.x, resY - winSize.y))
        if #list > 5 then
            table.remove(list, 1)
        end
        for k, data in ipairs(list) do
            ------------------------------------------------
            local default_data = {
                text = 'text',
                type = 0,
                time = 1500
            }
            for k, v in pairs(default_data) do
                if data[k] == nil then
                    data[k] = v
                end
            end
        
        
            local c = imgui.GetCursorPos()
            local p = imgui.GetCursorScreenPos()
            local DL = imgui.GetWindowDrawList()
            
            imgui.PushFont(FontsText[20])
            local textSize = imgui.CalcTextSize(data.text)
            imgui.PopFont()
            local size = imgui.ImVec2(10 + textSize.x + 5, textSize.y + 5)
        
        
            local winSize = imgui.GetWindowSize()
            if winSize.x > size.x + 20 then
                imgui.SetCursorPosX(winSize.x - size.x - 10)
            end
        
            
            imgui.PushStyleVarFloat(imgui.StyleVar.Alpha, data.alpha)
            imgui.PushStyleVarFloat(imgui.StyleVar.ChildRounding, 5)
            imgui.PushStyleVarVec2(imgui.StyleVar.ItemSpacing, imgui.ImVec2(0.0, 0.0))
            imgui.BeginChild('toastNotf:'..tostring(k)..tostring(data.text), size, false, imgui.WindowFlags.NoScrollbar + imgui.WindowFlags.NoScrollWithMouse + imgui.WindowFlags.AlwaysAutoResize)
                imgui.SetCursorPosY(0)
                imgui.PushFont(FontsText[20])
                imgui.TextColoredRGB(data.text, 1, true)
                imgui.PopFont()
            imgui.EndChild()
            imgui.PopStyleVar(3)
            ------------------------------------------------
        end
        
        imgui.End()
    end
)

function imgui.TextColoredRGB(text, render_text, shadow) -- & Возвращает цветной текст используя HEX.
    local max_float = imgui.GetWindowWidth()
    local style = imgui.GetStyle()
    local colors = style.Colors
    local ImVec4 = imgui.ImVec4
    local shadow = shadow or false

    local explode_argb = function(argb)
        local a = bit.band(bit.rshift(argb, 24), 0xFF)
        local r = bit.band(bit.rshift(argb, 16), 0xFF)
        local g = bit.band(bit.rshift(argb, 8), 0xFF)
        local b = bit.band(argb, 0xFF)
        return a, r, g, b
    end

    local designText = function(text__)
        local pos = imgui.GetCursorPos()
        if sampGetChatDisplayMode() == 2 then
            for i = 1, 1 --[[Степень тени]] do
                imgui.SetCursorPos(imgui.ImVec2(pos.x + i, pos.y))
                imgui.TextColored(imgui.ImVec4(0, 0, 0, 1), text__) -- shadow
                imgui.SetCursorPos(imgui.ImVec2(pos.x - i, pos.y))
                imgui.TextColored(imgui.ImVec4(0, 0, 0, 1), text__) -- shadow
                imgui.SetCursorPos(imgui.ImVec2(pos.x, pos.y + i))
                imgui.TextColored(imgui.ImVec4(0, 0, 0, 1), text__) -- shadow
                imgui.SetCursorPos(imgui.ImVec2(pos.x, pos.y - i))
                imgui.TextColored(imgui.ImVec4(0, 0, 0, 1), text__) -- shadow
            end
        end
        imgui.SetCursorPos(pos)
    end

    local getcolor = function(color)
        if string.upper(color:sub(1, 6)) == 'SSSSSS' then
            local r, g, b = colors[0].x, colors[0].y, colors[0].z
            local a = color:sub(7, 8) ~= 'FF' and (tonumber(color:sub(7, 8), 16)) or (colors[0].w * 255)
            return ImVec4(r, g, b, a / 255)
        end
        local color = type(color) == 'string' and tonumber(color, 16) or color
        if type(color) ~= 'number' then return end
        local r, g, b, a = explode_argb(color)
        return ImVec4(r / 255, g / 255, b / 255, a / 255)
    end

    local render_text = function(text_)
        for w in text_:gmatch('[^\r\n]+') do
            local text, colors_, m = {}, {}, 1
            w = w:gsub('{(......)}', '{%1FF}')
            while w:find('{........}') do
                local n, k = w:find('{........}')
                local color = getcolor(w:sub(n + 1, k - 1))
                if color then
                    text[#text], text[#text + 1] = w:sub(m, n - 1), w:sub(k + 1, #w)
                    colors_[#colors_ + 1] = color
                    m = n
                end
                w = w:sub(1, n - 1) .. w:sub(k + 1, #w)
            end
            local length = imgui.CalcTextSize(w)
            if render_text == 2 then
                imgui.NewLine()
                imgui.SameLine(max_float / 2 - (length.x / 2))
            elseif render_text == 3 then
                imgui.NewLine()
                imgui.SameLine(max_float - length.x - 5)
            end
            if text[0] then
                for i = 0, #text do
                    if shadow then
                        designText(text[i])
                    end
                    imgui.TextColored(colors_[i] or colors[0], text[i])
                    imgui.SameLine(nil, 0)
                end
                imgui.NewLine()
            else
                imgui.Text(w)
            end
        end
    end
    render_text(text)
end


function bringFloatTo(from, to, start_time, duration)
    local timer = os.clock() - start_time
    if timer >= 0.00 and timer <= duration then
        local count = timer / (duration / 100)
        return from + (count * (to - from) / 100), true
    end
    return (timer > duration) and to or from, false
end

function main()
   
    while true do
        wait(0)
        for k, data in ipairs(list) do
            --==[ UPDATE ALPHA ]==--
            if data.alpha == nil then list[k].alpha = 0 end
            if os.clock() - data.start < 0.5 then
                list[k].alpha = bringFloatTo(0, 1, data.start, 0.5)
            elseif data.time - 0.5 < os.clock() - data.start then
                list[k].alpha = bringFloatTo(1, 0, data.start + data.time - 0.5, 0.5)
            end

            --==[ REMOVE ]==--
            if os.clock() - data.start > data.time then
                table.remove(list, k)
            end
        end
    end
end
