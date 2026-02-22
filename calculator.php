<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'SF Mono', 'Consolas', 'Monaco', monospace;
        }

        body {
            background: #0a0a0f;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .calculator {
            background: linear-gradient(145deg, #12121a 0%, #0d0d12 100%);
            padding: 24px;
            border-radius: 20px;
            box-shadow: 
                0 0 40px rgba(0, 255, 204, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(0, 255, 204, 0.12);
        }

        .display {
            background: #08080c;
            border: 1px solid #1e1e2a;
            border-radius: 12px;
            padding: 20px 16px;
            margin-bottom: 20px;
            min-height: 72px;
            text-align: right;
        }

        .display-expression {
            color: #666;
            font-size: 14px;
            min-height: 20px;
            word-break: break-all;
        }

        .display-value {
            color: #00ffcc;
            font-size: 32px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .btn {
            padding: 18px;
            border: none;
            border-radius: 12px;
            font-size: 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #1a1a24;
            color: #e0e0e0;
            border: 1px solid #252532;
        }

        .btn:hover {
            background: #222230;
            transform: scale(1.03);
            border-color: #333;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-operator {
            background: linear-gradient(145deg, #1a2a28 0%, #152220 100%);
            color: #00ffcc;
            border-color: rgba(0, 255, 204, 0.2);
        }

        .btn-operator:hover {
            background: linear-gradient(145deg, #1f3532 0%, #1a2a28 100%);
            box-shadow: 0 0 15px rgba(0, 255, 204, 0.15);
        }

        .btn-equals {
            background: linear-gradient(145deg, #00ffcc 0%, #00ccaa 100%);
            color: #000;
            border: none;
        }

        .btn-equals:hover {
            box-shadow: 0 0 25px rgba(0, 255, 204, 0.4);
        }

        .btn-clear {
            background: #2a1a1a;
            color: #ff6b6b;
            border-color: rgba(255, 107, 107, 0.2);
        }

        .btn-clear:hover {
            background: #352020;
            box-shadow: 0 0 15px rgba(255, 107, 107, 0.15);
        }

        .span-two {
            grid-column: span 2;
        }
    </style>
</head>
<body>
    <form id="calculatorForm" method="post" action="calculator-result.php" style="display: contents;">
        <input type="hidden" name="expression" id="hiddenExpression" value="">
        <input type="hidden" name="result" id="hiddenResult" value="">
    </form>
    <div class="calculator">
        <div class="display">
            <div class="display-expression" id="expression"></div>
            <div class="display-value" id="display">0</div>
        </div>
        <div class="buttons">
            <button type="button" class="btn btn-clear" data-action="clear">C</button>
            <button type="button" class="btn btn-operator" data-action="toggle">±</button>
            <button type="button" class="btn btn-operator" data-action="percent">%</button>
            <button type="button" class="btn btn-operator" data-operator="÷">÷</button>

            <button type="button" class="btn" data-number="7">7</button>
            <button type="button" class="btn" data-number="8">8</button>
            <button type="button" class="btn" data-number="9">9</button>
            <button type="button" class="btn btn-operator" data-operator="×">×</button>

            <button type="button" class="btn" data-number="4">4</button>
            <button type="button" class="btn" data-number="5">5</button>
            <button type="button" class="btn" data-number="6">6</button>
            <button type="button" class="btn btn-operator" data-operator="-">−</button>

            <button type="button" class="btn" data-number="1">1</button>
            <button type="button" class="btn" data-number="2">2</button>
            <button type="button" class="btn" data-number="3">3</button>
            <button type="button" class="btn btn-operator" data-operator="+">+</button>

            <button type="button" class="btn span-two" data-number="0">0</button>
            <button type="button" class="btn" data-number=".">.</button>
            <button type="button" class="btn btn-equals" data-action="equals">=</button>
        </div>
    </div>

    <script>
        const display = document.getElementById('display');
        const expressionEl = document.getElementById('expression');

        let currentValue = '0';
        let previousValue = '';
        let operator = null;
        let shouldResetDisplay = false;

        function updateDisplay() {
            display.textContent = formatDisplay(currentValue);
            expressionEl.textContent = previousValue && operator 
                ? `${previousValue} ${operator}` 
                : '';
        }

        function formatDisplay(value) {
            if (value === '' || value === '-') return '0';
            const num = parseFloat(value);
            if (isNaN(num)) return '0';
            if (num > 999999999 || num < -999999999) return num.toExponential(2);
            const [intPart, decPart] = value.split('.');
            if (decPart !== undefined) {
                return intPart + '.' + decPart.slice(0, 8);
            }
            return value;
        }

        function inputNumber(num) {
            if (shouldResetDisplay) {
                currentValue = num === '.' ? '0.' : num;
                shouldResetDisplay = false;
            } else {
                if (num === '.') {
                    if (currentValue.includes('.')) return;
                    if (currentValue === '' || currentValue === '0') currentValue = '0';
                } else if (num === '0' && currentValue === '0') {
                    return;
                } else if (currentValue === '0' && num !== '.') {
                    currentValue = num;
                } else {
                    currentValue += num;
                }
            }
            updateDisplay();
        }

        function setOperator(op) {
            if (operator !== null && !shouldResetDisplay) {
                calculate();
            }
            previousValue = currentValue;
            operator = op;
            shouldResetDisplay = true;
            updateDisplay();
        }

        function calculate() {
            if (operator === null || previousValue === '') return;

            var firstNum = previousValue;
            var secondNum = currentValue;
            var op = operator;

            var prev = parseFloat(firstNum);
            var curr = parseFloat(secondNum);
            if (isNaN(prev) || isNaN(curr)) return;

            var computedResult;
            switch (op) {
                case '+': computedResult = prev + curr; break;
                case '−': computedResult = prev - curr; break;
                case '×': computedResult = prev * curr; break;
                case '÷': computedResult = curr === 0 ? NaN : prev / curr; break;
                default: return;
            }

            if (isNaN(computedResult)) {
                currentValue = 'Error';
                previousValue = '';
                operator = null;
                shouldResetDisplay = true;
                updateDisplay();
                return;
            }

            var expressionStr = firstNum + ' ' + op + ' ' + secondNum;
            var resultStr = String(Number.isInteger(computedResult) ? computedResult : parseFloat(computedResult.toPrecision(12)));

            document.getElementById('hiddenExpression').value = expressionStr;
            document.getElementById('hiddenResult').value = resultStr;
            document.getElementById('calculatorForm').submit();
        }

        function clear() {
            currentValue = '0';
            previousValue = '';
            operator = null;
            shouldResetDisplay = false;
            updateDisplay();
        }

        function toggleSign() {
            if (currentValue === '0' || currentValue === '') return;
            currentValue = currentValue.startsWith('-') 
                ? currentValue.slice(1) 
                : '-' + currentValue;
            updateDisplay();
        }

        function percent() {
            currentValue = String(parseFloat(currentValue) / 100);
            updateDisplay();
        }

        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', () => {
                if (btn.dataset.number !== undefined) {
                    inputNumber(btn.dataset.number);
                } else if (btn.dataset.operator !== undefined) {
                    setOperator(btn.dataset.operator);
                } else if (btn.dataset.action) {
                    const action = btn.dataset.action;
                    if (action === 'clear') clear();
                    else if (action === 'equals') calculate();
                    else if (action === 'toggle') toggleSign();
                    else if (action === 'percent') percent();
                }
            });
        });

        document.addEventListener('keydown', (e) => {
            if (e.key >= '0' && e.key <= '9') inputNumber(e.key);
            else if (e.key === '.') inputNumber('.');
            else if (e.key === '+') setOperator('+');
            else if (e.key === '-') setOperator('−');
            else if (e.key === '*') setOperator('×');
            else if (e.key === '/') { e.preventDefault(); setOperator('÷'); }
            else if (e.key === 'Enter') { e.preventDefault(); calculate(); }
            else if (e.key === 'Escape' || e.key === 'c' || e.key === 'C') clear();
        });

        updateDisplay();
    </script>
</body>
</html>
